<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassMethodsNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
/**
 * @implements Rule<ClassMethodsNode>
 */
class UnusedPrivateMethodRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassMethodsNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $constructor = null;
        if ($classReflection->hasConstructor()) {
            $constructor = $classReflection->getConstructor();
        }
        $classType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($classReflection->getName());
        $methods = [];
        foreach ($node->getMethods() as $method) {
            if (!$method->isPrivate()) {
                continue;
            }
            $methodName = $method->name->toString();
            if ($constructor !== null && $constructor->getName() === $methodName) {
                continue;
            }
            if (\strtolower($methodName) === '__clone') {
                continue;
            }
            $methods[$method->name->toString()] = $method;
        }
        $arrayCalls = [];
        foreach ($node->getMethodCalls() as $methodCall) {
            $methodCallNode = $methodCall->getNode();
            if ($methodCallNode instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_) {
                $arrayCalls[] = $methodCall;
                continue;
            }
            $callScope = $methodCall->getScope();
            if ($methodCallNode->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
                $methodNames = [$methodCallNode->name->toString()];
            } else {
                $methodNameType = $callScope->getType($methodCallNode->name);
                $strings = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($methodNameType);
                if (\count($strings) === 0) {
                    return [];
                }
                $methodNames = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $type) : string {
                    return $type->getValue();
                }, $strings);
            }
            if ($methodCallNode instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall) {
                $calledOnType = $callScope->getType($methodCallNode->var);
            } else {
                if (!$methodCallNode->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
                    continue;
                }
                $calledOnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($callScope->resolveName($methodCallNode->class));
            }
            if ($classType->isSuperTypeOf($calledOnType)->no()) {
                continue;
            }
            if ($calledOnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                continue;
            }
            $inMethod = $callScope->getFunction();
            if (!$inMethod instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection) {
                continue;
            }
            foreach ($methodNames as $methodName) {
                if ($inMethod->getName() === $methodName) {
                    continue;
                }
                unset($methods[$methodName]);
            }
        }
        if (\count($methods) > 0) {
            foreach ($arrayCalls as $arrayCall) {
                /** @var Node\Expr\Array_ $array */
                $array = $arrayCall->getNode();
                $arrayScope = $arrayCall->getScope();
                $arrayType = $scope->getType($array);
                if (!$arrayType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                    continue;
                }
                $typeAndMethod = $arrayType->findTypeAndMethodName();
                if ($typeAndMethod === null) {
                    continue;
                }
                if ($typeAndMethod->isUnknown()) {
                    return [];
                }
                if (!$typeAndMethod->getCertainty()->yes()) {
                    return [];
                }
                $calledOnType = $typeAndMethod->getType();
                if ($classType->isSuperTypeOf($calledOnType)->no()) {
                    continue;
                }
                if ($calledOnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                    continue;
                }
                $inMethod = $arrayScope->getFunction();
                if (!$inMethod instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection) {
                    continue;
                }
                if ($inMethod->getName() === $typeAndMethod->getMethod()) {
                    continue;
                }
                unset($methods[$typeAndMethod->getMethod()]);
            }
        }
        $errors = [];
        foreach ($methods as $methodName => $methodNode) {
            $methodType = 'Method';
            if ($methodNode->isStatic()) {
                $methodType = 'Static method';
            }
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s %s::%s() is unused.', $methodType, $classReflection->getDisplayName(), $methodName))->line($methodNode->getLine())->identifier('deadCode.unusedMethod')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'methodName' => $methodName])->build();
        }
        return $errors;
    }
}
