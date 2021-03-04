<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\MethodPrototypeNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter;
use function array_reduce;
use function count;
use function sprintf;
/**
 * @internal
 */
final class ReflectionMethodStringCast
{
    public static function toString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection, ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $rootClassReflection = null) : string
    {
        $parametersFormat = $methodReflection->getNumberOfParameters() > 0 ? "\n\n  - Parameters [%d] {%s\n  }" : '';
        return \sprintf('Method [ <%s%s%s%s%s%s>%s%s%s %s method %s ] {%s' . $parametersFormat . "\n}", self::sourceToString($methodReflection), $methodReflection->isConstructor() ? ', ctor' : '', $methodReflection->isDestructor() ? ', dtor' : '', self::overwritesToString($methodReflection), self::inheritsToString($methodReflection, $rootClassReflection), self::prototypeToString($methodReflection), $methodReflection->isFinal() ? ' final' : '', $methodReflection->isStatic() ? ' static' : '', $methodReflection->isAbstract() ? ' abstract' : '', self::visibilityToString($methodReflection), $methodReflection->getName(), self::fileAndLinesToString($methodReflection), \count($methodReflection->getParameters()), self::parametersToString($methodReflection));
    }
    private static function sourceToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : string
    {
        if ($methodReflection->isUserDefined()) {
            return 'user';
        }
        return \sprintf('internal:%s', $methodReflection->getExtensionName());
    }
    private static function overwritesToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : string
    {
        $parentClass = $methodReflection->getDeclaringClass()->getParentClass();
        if (!$parentClass) {
            return '';
        }
        if (!$parentClass->hasMethod($methodReflection->getName())) {
            return '';
        }
        return \sprintf(', overwrites %s', $parentClass->getName());
    }
    private static function inheritsToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection, ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $rootClassReflection) : string
    {
        if (!$rootClassReflection) {
            return '';
        }
        if ($methodReflection->getDeclaringClass()->getName() === $rootClassReflection->getName()) {
            return '';
        }
        return \sprintf(', inherits %s', $methodReflection->getDeclaringClass()->getName());
    }
    private static function prototypeToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : string
    {
        try {
            return \sprintf(', prototype %s', $methodReflection->getPrototype()->getDeclaringClass()->getName());
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\MethodPrototypeNotFound $e) {
            return '';
        }
    }
    private static function visibilityToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : string
    {
        if ($methodReflection->isProtected()) {
            return 'protected';
        }
        if ($methodReflection->isPrivate()) {
            return 'private';
        }
        return 'public';
    }
    private static function fileAndLinesToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : string
    {
        if ($methodReflection->isInternal()) {
            return '';
        }
        return \sprintf("\n  @@ %s %d - %d", $methodReflection->getFileName(), $methodReflection->getStartLine(), $methodReflection->getEndLine());
    }
    private static function parametersToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : string
    {
        return \array_reduce($methodReflection->getParameters(), static function (string $string, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter $parameterReflection) : string {
            return $string . "\n    " . \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionParameterStringCast::toString($parameterReflection);
        }, '');
    }
}
