<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class CountFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'count';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 1) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        if (\count($functionCall->args) > 1) {
            $mode = $scope->getType($functionCall->args[1]->value);
            if ($mode->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(\COUNT_RECURSIVE))->yes()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
            }
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($scope->getType($functionCall->args[0]->value));
        if (\count($constantArrays) === 0) {
            if ($argType->isIterableAtLeastOnce()->yes()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(1, null);
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $countTypes = [];
        foreach ($constantArrays as $array) {
            $countTypes[] = $array->count();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$countTypes);
    }
}
