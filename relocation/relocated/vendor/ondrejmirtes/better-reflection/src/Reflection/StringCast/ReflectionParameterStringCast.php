<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter;
use function is_array;
use function is_string;
use function sprintf;
use function strlen;
use function substr;
use function var_export;
/**
 * @internal
 */
final class ReflectionParameterStringCast
{
    public static function toString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter $parameterReflection) : string
    {
        return \sprintf('Parameter #%d [ %s %s%s%s$%s%s ]', $parameterReflection->getPosition(), $parameterReflection->isOptional() ? '<optional>' : '<required>', self::typeToString($parameterReflection), $parameterReflection->isVariadic() ? '...' : '', $parameterReflection->isPassedByReference() ? '&' : '', $parameterReflection->getName(), self::valueToString($parameterReflection));
    }
    private static function typeToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter $parameterReflection) : string
    {
        if (!$parameterReflection->hasType()) {
            return '';
        }
        $mapping = ['int' => 'integer', 'bool' => 'boolean'];
        $originalType = (string) $parameterReflection->getType();
        $type = $mapping[$originalType] ?? $originalType;
        if (!$parameterReflection->allowsNull()) {
            return $type . ' ';
        }
        return $type . ' or NULL ';
    }
    private static function valueToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter $parameterReflection) : string
    {
        if (!($parameterReflection->isOptional() && $parameterReflection->isDefaultValueAvailable())) {
            return '';
        }
        $defaultValue = $parameterReflection->getDefaultValue();
        if (\is_array($defaultValue)) {
            return ' = Array';
        }
        if (\is_string($defaultValue) && \strlen($defaultValue) > 15) {
            return ' = ' . \var_export(\substr($defaultValue, 0, 15) . '...', \true);
        }
        return ' = ' . \var_export($defaultValue, \true);
    }
}
