<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2612;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class TypeFactory
{
    /**
     * @phpstan-template T
     * @phpstan-param T $type
     * @phpstan-return T
     */
    public static function singleton($type)
    {
        return $type;
    }
}
class StringType
{
    public static function create(string $value) : self
    {
        $valueType = new static();
        $result = \TenantCloud\BetterReflection\Relocated\Bug2612\TypeFactory::singleton($valueType);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug2612\\StringType', $result);
        return $result;
    }
}
