<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use function array_key_exists;
use function sprintf;
use function strtolower;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InClassNode>
 */
class DuplicateDeclarationRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $classReflection = $scope->getClassReflection();
        if ($classReflection === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $errors = [];
        $declaredClassConstants = [];
        foreach ($node->getOriginalNode()->getConstants() as $constDecl) {
            foreach ($constDecl->consts as $const) {
                if (\array_key_exists($const->name->name, $declaredClassConstants)) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot redeclare constant %s::%s.', $classReflection->getDisplayName(), $const->name->name))->line($const->getLine())->nonIgnorable()->build();
                } else {
                    $declaredClassConstants[$const->name->name] = \true;
                }
            }
        }
        $declaredProperties = [];
        foreach ($node->getOriginalNode()->getProperties() as $propertyDecl) {
            foreach ($propertyDecl->props as $property) {
                if (\array_key_exists($property->name->name, $declaredProperties)) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot redeclare property %s::$%s.', $classReflection->getDisplayName(), $property->name->name))->line($property->getLine())->nonIgnorable()->build();
                } else {
                    $declaredProperties[$property->name->name] = \true;
                }
            }
        }
        $declaredFunctions = [];
        foreach ($node->getOriginalNode()->getMethods() as $method) {
            if ($method->name->toLowerString() === '__construct') {
                foreach ($method->params as $param) {
                    if ($param->flags === 0) {
                        continue;
                    }
                    if (!$param->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                    }
                    $propertyName = $param->var->name;
                    if (\array_key_exists($propertyName, $declaredProperties)) {
                        $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot redeclare property %s::$%s.', $classReflection->getDisplayName(), $propertyName))->line($param->getLine())->nonIgnorable()->build();
                    } else {
                        $declaredProperties[$propertyName] = \true;
                    }
                }
            }
            if (\array_key_exists(\strtolower($method->name->name), $declaredFunctions)) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot redeclare method %s::%s().', $classReflection->getDisplayName(), $method->name->name))->line($method->getStartLine())->nonIgnorable()->build();
            } else {
                $declaredFunctions[\strtolower($method->name->name)] = \true;
            }
        }
        return $errors;
    }
}
