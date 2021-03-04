<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryMinus;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use function in_array;
use function is_numeric;
class BcMathStringOrNullReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['bcdiv', 'bcmod', 'bcpowmod', 'bcsqrt'], \true);
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'bcsqrt') {
            return $this->getTypeForBcSqrt($functionCall, $scope);
        }
        if ($functionReflection->getName() === 'bcpowmod') {
            return $this->getTypeForBcPowMod($functionCall, $scope);
        }
        $stringAndNumericStringType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType());
        $defaultReturnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$stringAndNumericStringType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]);
        if (isset($functionCall->args[1]) === \false) {
            return $stringAndNumericStringType;
        }
        $secondArgument = $scope->getType($functionCall->args[1]->value);
        $secondArgumentIsNumeric = $secondArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && \is_numeric($secondArgument->getValue()) || $secondArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
        if ($secondArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && ($this->isZero($secondArgument->getValue()) || !$secondArgumentIsNumeric)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        if (isset($functionCall->args[2]) === \false) {
            if ($secondArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType || $secondArgumentIsNumeric) {
                return $stringAndNumericStringType;
            }
            return $defaultReturnType;
        }
        $thirdArgument = $scope->getType($functionCall->args[2]->value);
        $thirdArgumentIsNumeric = $thirdArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && \is_numeric($thirdArgument->getValue()) || $thirdArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
        if ($thirdArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && !\is_numeric($thirdArgument->getValue())) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        if (($secondArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType || $secondArgumentIsNumeric) && $thirdArgumentIsNumeric) {
            return $stringAndNumericStringType;
        }
        return $defaultReturnType;
    }
    /**
     * bcsqrt
     * https://www.php.net/manual/en/function.bcsqrt.php
     * > Returns the square root as a string, or NULL if operand is negative.
     *
     * @param FuncCall $functionCall
     * @param Scope $scope
     * @return Type
     */
    private function getTypeForBcSqrt(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $stringAndNumericStringType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType());
        $defaultReturnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$stringAndNumericStringType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]);
        if (isset($functionCall->args[0]) === \false) {
            return $defaultReturnType;
        }
        $firstArgument = $scope->getType($functionCall->args[0]->value);
        $firstArgumentIsPositive = $firstArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && \is_numeric($firstArgument->getValue()) && $firstArgument->getValue() >= 0;
        $firstArgumentIsNegative = $firstArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && \is_numeric($firstArgument->getValue()) && $firstArgument->getValue() < 0;
        if ($firstArgument instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryMinus || $firstArgumentIsNegative) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        if (isset($functionCall->args[1]) === \false) {
            if ($firstArgumentIsPositive) {
                return $stringAndNumericStringType;
            }
            return $defaultReturnType;
        }
        $secondArgument = $scope->getType($functionCall->args[1]->value);
        $secondArgumentIsValid = $secondArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && \is_numeric($secondArgument->getValue()) && !$this->isZero($secondArgument->getValue());
        $secondArgumentIsNonNumeric = $secondArgument instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && !\is_numeric($secondArgument->getValue());
        if ($secondArgumentIsNonNumeric) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        if ($firstArgumentIsPositive && $secondArgumentIsValid) {
            return $stringAndNumericStringType;
        }
        return $defaultReturnType;
    }
    /**
     * bcpowmod()
     * https://www.php.net/manual/en/function.bcpowmod.php
     * > Returns the result as a string, or FALSE if modulus is 0 or exponent is negative.
     * @param FuncCall $functionCall
     * @param Scope $scope
     * @return Type
     */
    private function getTypeForBcPowMod(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $stringAndNumericStringType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType());
        if (isset($functionCall->args[1]) === \false) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$stringAndNumericStringType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        $exponent = $scope->getType($functionCall->args[1]->value);
        $exponentIsNegative = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(null, 0)->isSuperTypeOf($exponent)->yes();
        if ($exponent instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
            $exponentIsNegative = \is_numeric($exponent->getValue()) && $exponent->getValue() < 0;
        }
        if ($exponentIsNegative) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        if (isset($functionCall->args[2])) {
            $modulus = $scope->getType($functionCall->args[2]->value);
            $modulusIsZero = $modulus instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && $this->isZero($modulus->getValue());
            $modulusIsNonNumeric = $modulus instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && !\is_numeric($modulus->getValue());
            if ($modulusIsZero || $modulusIsNonNumeric) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            if ($modulus instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
                return $stringAndNumericStringType;
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$stringAndNumericStringType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
    }
    /**
     * Utility to help us determine if value is zero. Handles cases where we pass "0.000" too.
     *
     * @param mixed $value
     * @return bool
     */
    private function isZero($value) : bool
    {
        if (\is_numeric($value) === \false) {
            return \false;
        }
        if ($value > 0 || $value < 0) {
            return \false;
        }
        return \true;
    }
}
