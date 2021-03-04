<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionReturnTypeCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ReturnTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck)
    {
        $this->returnTypeCheck = $returnTypeCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        if ($scope->isInAnonymousFunction()) {
            return [];
        }
        $method = $scope->getFunction();
        if (!$method instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $reflection = null;
        if ($method->getDeclaringClass()->getNativeReflection()->hasMethod($method->getName())) {
            $reflection = $method->getDeclaringClass()->getNativeReflection()->getMethod($method->getName());
        }
        return $this->returnTypeCheck->checkReturnType($scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType(), $node->expr, $node, \sprintf('Method %s::%s() should return %%s but empty return statement found.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() with return type void returns %%s but should not return anything.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() should return %%s but returns %%s.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() should never return but return statement found.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), $reflection !== null && $reflection->isGenerator());
    }
}
