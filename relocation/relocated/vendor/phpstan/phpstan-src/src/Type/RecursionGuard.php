<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

class RecursionGuard
{
    /** @var true[] */
    private static array $context = [];
    /**
     * @param Type $type
     * @param callable(): Type $callback
     *
     * @return Type
     */
    public static function run(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $callback) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $key = $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value());
        if (isset(self::$context[$key])) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        try {
            self::$context[$key] = \true;
            return $callback();
        } finally {
            unset(self::$context[$key]);
        }
    }
}
