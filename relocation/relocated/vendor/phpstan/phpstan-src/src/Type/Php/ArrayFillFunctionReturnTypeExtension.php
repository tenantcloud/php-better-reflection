<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ArrayFillFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const MAX_SIZE_USE_CONSTANT_ARRAY = 100;
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 3) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startIndexType = $scope->getType($functionCall->args[0]->value);
        $numberType = $scope->getType($functionCall->args[1]->value);
        $valueType = $scope->getType($functionCall->args[2]->value);
        if ($startIndexType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && $numberType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() <= static::MAX_SIZE_USE_CONSTANT_ARRAY) {
            $arrayBuilder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            $nextIndex = $startIndexType->getValue();
            for ($i = 0; $i < $numberType->getValue(); $i++) {
                $arrayBuilder->setOffsetValueType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($nextIndex), $valueType);
                if ($nextIndex < 0) {
                    $nextIndex = 0;
                } else {
                    $nextIndex++;
                }
            }
            return $arrayBuilder->getArray();
        }
        if ($numberType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() > 0) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $valueType), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType()]);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $valueType);
    }
}
