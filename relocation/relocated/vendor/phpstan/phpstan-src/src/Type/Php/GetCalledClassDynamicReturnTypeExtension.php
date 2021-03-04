<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class GetCalledClassDynamicReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_called_class';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $classContext = $scope->getClassReflection();
        if ($classContext !== null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType($classContext->getName(), \true);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
