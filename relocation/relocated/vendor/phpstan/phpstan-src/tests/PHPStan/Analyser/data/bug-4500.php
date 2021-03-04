<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4500TypeInference;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFirst() : void
    {
        global $foo;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
    }
    public function doFoo() : void
    {
        /** @var int */
        global $foo;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo);
    }
    public function doBar() : void
    {
        /** @var int $foo */
        global $foo;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo);
    }
    public function doBaz() : void
    {
        /** @var int */
        global $foo, $bar;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $bar);
    }
    public function doLorem() : void
    {
        /** @var int $foo */
        global $foo, $bar;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $bar);
        $baz = 'foo';
        /** @var int $baz */
        global $lorem;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $lorem);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', $baz);
    }
    public function doIpsum() : void
    {
        /**
         * @var int $foo
         * @var string $bar
         */
        global $foo, $bar;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $bar);
    }
    public function doDolor() : void
    {
        /** @var int $baz */
        global $lorem;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $lorem);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*ERROR*', $baz);
    }
    public function doSit() : void
    {
        /** @var array<int|\stdClass> $modelPropertyParameter */
        $modelPropertyParameter = doFoo();
        /** @var int $parameterIndex */
        /** @var \stdClass $modelType */
        [$parameterIndex, $modelType] = $modelPropertyParameter;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $parameterIndex);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $modelType);
    }
    public function doAmet(array $slots) : void
    {
        /** @var \stdClass[] $itemSlots */
        /** @var \stdClass[] $slots */
        $itemSlots = [];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<stdClass>', $itemSlots);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<stdClass>', $slots);
    }
    public function listDestructuring() : void
    {
        /** @var int $test */
        [[$test]] = doFoo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $test);
    }
    public function listDestructuring2() : void
    {
        /** @var int $test */
        [$test] = doFoo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $test);
    }
    public function listDestructuringForeach() : void
    {
        /** @var int $value */
        foreach (doFoo() as [[$value]]) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $value);
        }
    }
    public function listDestructuringForeach2() : void
    {
        /** @var int $value */
        foreach (doFoo() as [$value]) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $value);
        }
    }
    public function doConseteur() : void
    {
        /**
         * @var int $foo
         * @var string $bar
         */
        [$foo, $bar] = doFoo();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $bar);
    }
}
