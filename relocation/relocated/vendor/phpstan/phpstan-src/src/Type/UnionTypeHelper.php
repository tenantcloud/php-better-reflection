<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
class UnionTypeHelper
{
    /**
     * @param \PHPStan\Type\Type[] $types
     * @return string[]
     */
    public static function getReferencedClasses(array $types) : array
    {
        $subTypeClasses = [];
        foreach ($types as $type) {
            $subTypeClasses[] = $type->getReferencedClasses();
        }
        return \array_merge(...$subTypeClasses);
    }
    /**
     * @param \PHPStan\Type\Type[] $types
     * @return \PHPStan\Type\Type[]
     */
    public static function sortTypes(array $types) : array
    {
        \usort($types, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $a, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $b) : int {
            if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType) {
                return 1;
            } elseif ($b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType) {
                return -1;
            }
            if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType) {
                if ($b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType) {
                    return \strcasecmp($a->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $b->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()));
                }
                return 1;
            }
            if ($b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType) {
                return -1;
            }
            $aIsBool = $a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
            $bIsBool = $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
            if ($aIsBool && !$bIsBool) {
                return 1;
            } elseif ($bIsBool && !$aIsBool) {
                return -1;
            }
            if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && !$b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
                return -1;
            } elseif (!$a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
                return 1;
            }
            if (($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType || $a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType) && ($b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType || $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType)) {
                $cmp = $a->getValue() <=> $b->getValue();
                if ($cmp !== 0) {
                    return $cmp;
                }
                if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType) {
                    return -1;
                }
                if ($b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && $a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType) {
                    return 1;
                }
                return 0;
            }
            if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType && $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType) {
                return ($a->getMin() ?? \PHP_INT_MIN) <=> ($b->getMin() ?? \PHP_INT_MIN);
            }
            if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType && $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                return \strcasecmp($a->getValue(), $b->getValue());
            }
            if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType && $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                if ($a->isEmpty()) {
                    if ($b->isEmpty()) {
                        return 0;
                    }
                    return -1;
                } elseif ($b->isEmpty()) {
                    return 1;
                }
                return \strcasecmp($a->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $b->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()));
            }
            return \strcasecmp($a->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $b->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()));
        });
        return $types;
    }
}
