<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class RangeFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const RANGE_LENGTH_THRESHOLD = 50;
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'range';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startType = $scope->getType($functionCall->args[0]->value);
        $endType = $scope->getType($functionCall->args[1]->value);
        $stepType = \count($functionCall->args) >= 3 ? $scope->getType($functionCall->args[2]->value) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1);
        $constantReturnTypes = [];
        $startConstants = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantScalars($startType);
        foreach ($startConstants as $startConstant) {
            if (!$startConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && !$startConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType && !$startConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $endConstants = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantScalars($endType);
            foreach ($endConstants as $endConstant) {
                if (!$endConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && !$endConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType && !$endConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $stepConstants = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantScalars($stepType);
                foreach ($stepConstants as $stepConstant) {
                    if (!$stepConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && !$stepConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType) {
                        continue;
                    }
                    $rangeValues = \range($startConstant->getValue(), $endConstant->getValue(), $stepConstant->getValue());
                    if (\count($rangeValues) > self::RANGE_LENGTH_THRESHOLD) {
                        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($startConstant->generalize(), $endConstant->generalize())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType()]);
                    }
                    $arrayBuilder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                    foreach ($rangeValues as $value) {
                        $arrayBuilder->setOffsetValueType(null, $scope->getTypeFromValue($value));
                    }
                    $constantReturnTypes[] = $arrayBuilder->getArray();
                }
            }
        }
        if (\count($constantReturnTypes) > 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$constantReturnTypes);
        }
        $argType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($startType, $endType);
        $isInteger = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType())->isSuperTypeOf($argType)->yes();
        $isStepInteger = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType())->isSuperTypeOf($stepType)->yes();
        if ($isInteger && $isStepInteger) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType());
        }
        $isFloat = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType())->isSuperTypeOf($argType)->yes();
        if ($isFloat) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType());
        }
        $numberType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]);
        $isNumber = $numberType->isSuperTypeOf($argType)->yes();
        if ($isNumber) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $numberType);
        }
        $isString = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($argType)->yes();
        if ($isString) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType());
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]));
    }
}
