<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToStaticMethodStamentWithoutSideEffectsRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall) {
            return [];
        }
        $staticCall = $node->expr;
        if (!$staticCall->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $staticCall->name->toString();
        if ($staticCall->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $className = $scope->resolveName($staticCall->class);
            if (!$this->reflectionProvider->hasClass($className)) {
                return [];
            }
            $calledOnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($className);
        } else {
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $staticCall->class, '', static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($methodName) : bool {
                return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
            });
            $calledOnType = $typeResult->getType();
            if ($calledOnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                return [];
            }
        }
        if (!$calledOnType->canCallMethods()->yes()) {
            return [];
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return [];
        }
        $method = $calledOnType->getMethod($methodName, $scope);
        if (\strtolower($method->getName()) === '__construct' || \strtolower($method->getName()) === \strtolower($method->getDeclaringClass()->getName())) {
            return [];
        }
        if ($method->hasSideEffects()->no()) {
            $throwsType = $method->getThrowType();
            if ($throwsType !== null && !$throwsType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType) {
                return [];
            }
            $methodResult = $scope->getType($staticCall);
            if ($methodResult instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && $methodResult->isExplicit()) {
                return [];
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s::%s() on a separate line has no effect.', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        return [];
    }
}
