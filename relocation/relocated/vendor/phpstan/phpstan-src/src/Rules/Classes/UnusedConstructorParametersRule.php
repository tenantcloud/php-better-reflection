<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UnusedFunctionParametersCheck;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class UnusedConstructorParametersRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UnusedFunctionParametersCheck $check;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UnusedFunctionParametersCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $method = $scope->getFunction();
        if (!$method instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $originalNode = $node->getOriginalNode();
        if (\strtolower($method->getName()) !== '__construct' || $originalNode->stmts === null) {
            return [];
        }
        if (\count($originalNode->params) === 0) {
            return [];
        }
        $message = \sprintf('Constructor of class %s has an unused parameter $%%s.', $scope->getClassReflection()->getDisplayName());
        if ($scope->getClassReflection()->isAnonymous()) {
            $message = 'Constructor of an anonymous class has an unused parameter $%s.';
        }
        return $this->check->getUnusedParameters($scope, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param $parameter) : string {
            if (!$parameter->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($parameter->var->name)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            return $parameter->var->name;
        }, \array_values(\array_filter($originalNode->params, static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param $parameter) : bool {
            return $parameter->flags === 0;
        }))), $originalNode->stmts, $message, 'constructor.unusedParameter', []);
    }
}
