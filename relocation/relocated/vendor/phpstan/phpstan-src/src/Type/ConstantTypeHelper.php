<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
class ConstantTypeHelper
{
    /**
     * @param mixed $value
     */
    public static function getTypeFromValue($value) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\is_int($value)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($value);
        } elseif (\is_float($value)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType($value);
        } elseif (\is_bool($value)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType($value);
        } elseif ($value === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        } elseif (\is_string($value)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType($value);
        } elseif (\is_array($value)) {
            $arrayBuilder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($value as $k => $v) {
                $arrayBuilder->setOffsetValueType(self::getTypeFromValue($k), self::getTypeFromValue($v));
            }
            return $arrayBuilder->getArray();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
    }
}
