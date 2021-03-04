<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
class StaticTypeFactory
{
    public static function falsey() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        static $falsey;
        if ($falsey === null) {
            $falsey = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(''), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('0'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], [])]);
        }
        return $falsey;
    }
    public static function truthy() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        static $truthy;
        if ($truthy === null) {
            $truthy = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\false, self::falsey());
        }
        return $truthy;
    }
}
