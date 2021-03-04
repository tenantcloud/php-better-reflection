<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class ArrayRandFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_rand';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if (\count($functionCall->args) < 1) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $firstArgType = $scope->getType($functionCall->args[0]->value);
        $isInteger = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType())->isSuperTypeOf($firstArgType->getIterableKeyType());
        $isString = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($firstArgType->getIterableKeyType());
        if ($isInteger->yes()) {
            $valueType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        } elseif ($isString->yes()) {
            $valueType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
        } else {
            $valueType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]);
        }
        if ($argsCount < 2) {
            return $valueType;
        }
        $secondArgType = $scope->getType($functionCall->args[1]->value);
        if ($secondArgType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($secondArgType->getValue() === 1) {
                return $valueType;
            }
            if ($secondArgType->getValue() >= 2) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $valueType);
            }
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($valueType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $valueType));
    }
}
