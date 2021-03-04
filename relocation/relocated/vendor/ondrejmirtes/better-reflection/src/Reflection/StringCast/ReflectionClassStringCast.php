<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionObject;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty;
use function array_filter;
use function array_map;
use function count;
use function implode;
use function preg_replace;
use function sprintf;
use function str_repeat;
use function strtolower;
use function trim;
/**
 * @internal
 */
final class ReflectionClassStringCast
{
    public static function toString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : string
    {
        $isObject = $classReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionObject;
        $format = "%s [ <%s> %s%s%s %s%s%s ] {\n";
        $format .= "%s\n";
        $format .= "  - Constants [%d] {%s\n  }\n\n";
        $format .= "  - Static properties [%d] {%s\n  }\n\n";
        $format .= "  - Static methods [%d] {%s\n  }\n\n";
        $format .= "  - Properties [%d] {%s\n  }\n\n";
        $format .= $isObject ? "  - Dynamic properties [%d] {%s\n  }\n\n" : '%s%s';
        $format .= "  - Methods [%d] {%s\n  }\n";
        $format .= "}\n";
        $type = self::typeToString($classReflection);
        $constants = $classReflection->getReflectionConstants();
        $staticProperties = self::getStaticProperties($classReflection);
        $staticMethods = self::getStaticMethods($classReflection);
        $defaultProperties = self::getDefaultProperties($classReflection);
        $dynamicProperties = self::getDynamicProperties($classReflection);
        $methods = self::getMethods($classReflection);
        return \sprintf($format, $isObject ? 'Object of class' : $type, self::sourceToString($classReflection), $classReflection->isFinal() ? 'final ' : '', $classReflection->isAbstract() ? 'abstract ' : '', \strtolower($type), $classReflection->getName(), self::extendsToString($classReflection), self::implementsToString($classReflection), self::fileAndLinesToString($classReflection), \count($constants), self::constantsToString($constants), \count($staticProperties), self::propertiesToString($staticProperties), \count($staticMethods), self::methodsToString($classReflection, $staticMethods), \count($defaultProperties), self::propertiesToString($defaultProperties), $isObject ? \count($dynamicProperties) : '', $isObject ? self::propertiesToString($dynamicProperties) : '', \count($methods), self::methodsToString($classReflection, $methods, 2));
    }
    private static function typeToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : string
    {
        if ($classReflection->isInterface()) {
            return 'Interface';
        }
        if ($classReflection->isTrait()) {
            return 'Trait';
        }
        return 'Class';
    }
    private static function sourceToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : string
    {
        if ($classReflection->isUserDefined()) {
            return 'user';
        }
        return \sprintf('internal:%s', $classReflection->getExtensionName());
    }
    private static function extendsToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : string
    {
        $parentClass = $classReflection->getParentClass();
        if (!$parentClass) {
            return '';
        }
        return ' extends ' . $parentClass->getName();
    }
    private static function implementsToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : string
    {
        $interfaceNames = $classReflection->getInterfaceNames();
        if (!$interfaceNames) {
            return '';
        }
        return ' implements ' . \implode(', ', $interfaceNames);
    }
    private static function fileAndLinesToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : string
    {
        if ($classReflection->isInternal()) {
            return '';
        }
        return \sprintf("  @@ %s %d-%d\n", $classReflection->getFileName(), $classReflection->getStartLine(), $classReflection->getEndLine());
    }
    /**
     * @param ReflectionClassConstant[] $constants
     */
    private static function constantsToString(array $constants) : string
    {
        if (!$constants) {
            return '';
        }
        return self::itemsToString(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant $constantReflection) : string {
            return \trim(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionClassConstantStringCast::toString($constantReflection));
        }, $constants));
    }
    /**
     * @param ReflectionProperty[] $properties
     */
    private static function propertiesToString(array $properties) : string
    {
        if (!$properties) {
            return '';
        }
        return self::itemsToString(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : string {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionPropertyStringCast::toString($propertyReflection);
        }, $properties));
    }
    /**
     * @param ReflectionMethod[] $methods
     */
    private static function methodsToString(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection, array $methods, int $emptyLinesAmongItems = 1) : string
    {
        if (!$methods) {
            return '';
        }
        return self::itemsToString(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $method) use($classReflection) : string {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\StringCast\ReflectionMethodStringCast::toString($method, $classReflection);
        }, $methods), $emptyLinesAmongItems);
    }
    /**
     * @param string[] $items
     */
    private static function itemsToString(array $items, int $emptyLinesAmongItems = 1) : string
    {
        $string = \implode(\str_repeat("\n", $emptyLinesAmongItems), $items);
        return "\n" . \preg_replace('/(^|\\n)(?!\\n)/', '\\1' . self::indent(), $string);
    }
    private static function indent() : string
    {
        return \str_repeat(' ', 4);
    }
    /**
     * @return ReflectionProperty[]
     */
    private static function getStaticProperties(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : array
    {
        return \array_filter($classReflection->getProperties(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : bool {
            return $propertyReflection->isStatic();
        });
    }
    /**
     * @return ReflectionMethod[]
     */
    private static function getStaticMethods(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : array
    {
        return \array_filter($classReflection->getMethods(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : bool {
            return $methodReflection->isStatic();
        });
    }
    /**
     * @return ReflectionProperty[]
     */
    private static function getDefaultProperties(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : array
    {
        return \array_filter($classReflection->getProperties(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : bool {
            return !$propertyReflection->isStatic() && $propertyReflection->isDefault();
        });
    }
    /**
     * @return ReflectionProperty[]
     */
    private static function getDynamicProperties(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : array
    {
        return \array_filter($classReflection->getProperties(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $propertyReflection) : bool {
            return !$propertyReflection->isStatic() && !$propertyReflection->isDefault();
        });
    }
    /**
     * @return ReflectionMethod[]
     */
    private static function getMethods(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $classReflection) : array
    {
        return \array_filter($classReflection->getMethods(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $methodReflection) : bool {
            return !$methodReflection->isStatic();
        });
    }
}
