<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ClosureBindDynamicReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \Closure::class;
    }
    public function isStaticMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'bind';
    }
    public function getTypeFromStaticMethodCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall $methodCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $closureType = $scope->getType($methodCall->args[0]->value);
        if (!$closureType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        return $closureType;
    }
}
