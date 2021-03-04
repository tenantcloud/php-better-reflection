<?php

namespace TenantCloud\BetterReflection\Relocated\PHPStan\Generics\GenericClassStringType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class C
{
    public static function f() : int
    {
        return 0;
    }
}
/**
 * @param mixed $a
 */
function testMixed($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~string', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<DateTimeInterface>|DateTimeInterface', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    }
    if (\is_subclass_of($a, 'DateTimeInterface') || \is_subclass_of($a, 'stdClass')) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<DateTimeInterface>|class-string<stdClass>|DateTimeInterface|stdClass', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface|stdClass', new $a());
    }
    if (\is_subclass_of($a, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\GenericClassStringType\C::class)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a::f());
    }
}
/**
 * @param object $a
 */
function testObject($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~string', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', $a);
    }
}
/**
 * @param string $a
 */
function testString($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~string', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<DateTimeInterface>', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    }
    if (\is_subclass_of($a, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\GenericClassStringType\C::class)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a::f());
    }
}
/**
 * @param string|object $a
 */
function testStringObject($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~string', new $a());
    if (\is_subclass_of($a, 'DateTimeInterface')) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<DateTimeInterface>|DateTimeInterface', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    }
    if (\is_subclass_of($a, \TenantCloud\BetterReflection\Relocated\PHPStan\Generics\GenericClassStringType\C::class)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a::f());
    }
}
/**
 * @param class-string<\DateTimeInterface> $a
 */
function testClassString($a)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', new $a());
    if (\is_subclass_of($a, 'DateTime')) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string<DateTime>', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTime', new $a());
    }
}
function testClassExists(string $str)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $str);
    if (\class_exists($str)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', $str);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~string', new $str());
    }
    $existentClass = \stdClass::class;
    if (\class_exists($existentClass)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'stdClass\'', $existentClass);
    }
    $nonexistentClass = 'NonexistentClass';
    if (\class_exists($nonexistentClass)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'NonexistentClass\'', $nonexistentClass);
    }
}
function testInterfaceExists(string $str)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $str);
    if (\interface_exists($str)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', $str);
    }
}
function testTraitExists(string $str)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $str);
    if (\trait_exists($str)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('class-string', $str);
    }
}
