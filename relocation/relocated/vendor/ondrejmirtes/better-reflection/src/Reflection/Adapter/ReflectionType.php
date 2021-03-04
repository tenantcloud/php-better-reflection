<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter;

use LogicException;
use ReflectionType as CoreReflectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionNamedType as BetterReflectionNamedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionType as BetterReflectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionUnionType as BetterReflectionUnionType;
use function get_class;
use function sprintf;
class ReflectionType
{
    private function __construct()
    {
    }
    public static function fromReturnTypeOrNull(?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionType $betterReflectionType) : ?\ReflectionType
    {
        if ($betterReflectionType === null) {
            return null;
        }
        if ($betterReflectionType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionNamedType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionNamedType($betterReflectionType);
        }
        if ($betterReflectionType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionUnionType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionUnionType($betterReflectionType);
        }
        throw new \LogicException(\sprintf('%s is not supported.', \get_class($betterReflectionType)));
    }
}
