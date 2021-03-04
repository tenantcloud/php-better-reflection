<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty;
use function sprintf;
/**
 * @internal
 */
final class ReflectionPropertyStringCast
{
    public static function toString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
    {
        $stateModifier = '';
        if (!$propertyReflection->isStatic()) {
            $stateModifier = $propertyReflection->isDefault() ? ' <default>' : ' <dynamic>';
        }
        return \sprintf('Property [%s %s%s $%s ]', $stateModifier, self::visibilityToString($propertyReflection), $propertyReflection->isStatic() ? ' static' : '', $propertyReflection->getName());
    }
    private static function visibilityToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string
    {
        if ($propertyReflection->isProtected()) {
            return 'protected';
        }
        if ($propertyReflection->isPrivate()) {
            return 'private';
        }
        return 'public';
    }
}
