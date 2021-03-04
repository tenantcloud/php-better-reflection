<?php

namespace TenantCloud\BetterReflection\Relocated\NativeTypes;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType;
class Foo
{
    /**
     * @param self $foo
     * @param \DateTimeImmutable $dateTime
     * @param \DateTimeImmutable $dateTimeMutable
     * @param string $nullableString
     * @param string|null $nonNullableString
     */
    public function doFoo($foo, \DateTimeInterface $dateTime, \DateTime $dateTimeMutable, ?string $nullableString, string $nonNullableString) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $foo);
        // change type after assignment
        $foo = new \TenantCloud\BetterReflection\Relocated\NativeTypes\Foo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        $f = function (\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo $foo) use($dateTime) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTime::class, $dateTimeMutable);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTime::class, $dateTimeMutable);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $nullableString);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('string|null', $nullableString);
        if (\is_string($nullableString)) {
            // change specified type
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $nullableString);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('string', $nullableString);
            // preserve other variables
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        }
        // preserve after merging scopes
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $nonNullableString);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('string', $nonNullableString);
        unset($nonNullableString);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*ERROR*', $nonNullableString);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('*ERROR*', $nonNullableString);
        // preserve other variables
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
    }
    /**
     * @param array<string, int> $array
     */
    public function doForeach(array $array) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, int>', $array);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array', $array);
        foreach ($array as $key => $value) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, int>&nonEmpty', $array);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array&nonEmpty', $array);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $key);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('(int|string)', $key);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $value);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $value);
        }
    }
    /**
     * @param self $foo
     */
    public function doCatch($foo) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $foo);
        try {
            throw new \Exception();
        } catch (\InvalidArgumentException $foo) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\InvalidArgumentException::class, $foo);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\InvalidArgumentException::class, $foo);
        } catch (\Exception $e) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\Exception::class, $e);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\Exception::class, $e);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $foo);
        }
    }
    /**
     * @param array<string, array{int, string}> $array
     */
    public function doForeachArrayDestructuring(array $array)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, array(int, string)>', $array);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array', $array);
        foreach ($array as $key => [$i, $s]) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, array(int, string)>&nonEmpty', $array);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array&nonEmpty', $array);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $key);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('(int|string)', $key);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $i);
            // assertNativeType('mixed', $i);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $s);
            // assertNativeType('mixed', $s);
        }
    }
    /**
     * @param \DateTimeImmutable $date
     */
    public function doIfElse(\DateTimeInterface $date) : void
    {
        if ($date instanceof \DateTimeInterface) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $date);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $date);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('*NEVER*', $date);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $date);
        if ($date instanceof \DateTimeImmutable) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeImmutable::class, $date);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $date);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('DateTimeInterface~DateTimeImmutable', $date);
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $date);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeImmutable::class, $date);
        // could be DateTimeInterface
        if ($date instanceof \DateTime) {
        }
    }
}
/**
 * @param Foo $foo
 * @param \DateTimeImmutable $dateTime
 * @param \DateTimeImmutable $dateTimeMutable
 * @param string $nullableString
 * @param string|null $nonNullableString
 */
function fooFunction($foo, \DateTimeInterface $dateTime, \DateTime $dateTimeMutable, ?string $nullableString, string $nonNullableString) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NativeTypes\Foo::class, $foo);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('mixed', $foo);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTimeImmutable::class, $dateTime);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTimeInterface::class, $dateTime);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\DateTime::class, $dateTimeMutable);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType(\DateTime::class, $dateTimeMutable);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $nullableString);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('string|null', $nullableString);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $nonNullableString);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('string', $nonNullableString);
}
