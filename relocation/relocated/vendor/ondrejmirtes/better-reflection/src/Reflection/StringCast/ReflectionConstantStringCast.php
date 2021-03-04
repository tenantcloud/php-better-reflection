<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant;
use function assert;
use function gettype;
use function is_scalar;
use function sprintf;
/**
 * Implementation of ReflectionConstant::__toString()
 *
 * @internal
 */
final class ReflectionConstantStringCast
{
    public static function toString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant $constantReflection) : string
    {
        $value = $constantReflection->getValue();
        \assert($value === null || \is_scalar($value));
        return \sprintf('Constant [ <%s> %s %s ] {%s %s }', self::sourceToString($constantReflection), \gettype($value), $constantReflection->getName(), self::fileAndLinesToString($constantReflection), (string) $value);
    }
    private static function sourceToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant $constantReflection) : string
    {
        if ($constantReflection->isUserDefined()) {
            return 'user';
        }
        return \sprintf('internal:%s', $constantReflection->getExtensionName());
    }
    private static function fileAndLinesToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant $constantReflection) : string
    {
        if ($constantReflection->isInternal()) {
            return '';
        }
        return \sprintf("\n  @@ %s %d - %d\n", $constantReflection->getFileName(), $constantReflection->getStartLine(), $constantReflection->getEndLine());
    }
}
