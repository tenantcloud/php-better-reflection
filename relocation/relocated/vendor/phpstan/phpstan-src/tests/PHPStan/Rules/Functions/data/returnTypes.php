<?php

namespace TenantCloud\BetterReflection\Relocated\ReturnTypes;

function returnNothing()
{
    return;
}
function returnInteger() : int
{
    if (\rand(0, 1)) {
        return 1;
    }
    if (\rand(0, 1)) {
        return 'foo';
    }
    $foo = function () {
        return 'bar';
    };
}
function returnObject() : \TenantCloud\BetterReflection\Relocated\ReturnTypes\Bar
{
    if (\rand(0, 1)) {
        return 1;
    }
    if (\rand(0, 1)) {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\Foo();
    }
    if (\rand(0, 1)) {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\Bar();
    }
}
function returnChild() : \TenantCloud\BetterReflection\Relocated\ReturnTypes\Foo
{
    if (\rand(0, 1)) {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\Foo();
    }
    if (\rand(0, 1)) {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\FooChild();
    }
    if (\rand(0, 1)) {
        return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\OtherInterfaceImpl();
    }
}
/**
 * @return string|null
 */
function returnNullable()
{
    if (\rand(0, 1)) {
        return 'foo';
    }
    if (\rand(0, 1)) {
        return null;
    }
}
function returnInterface() : \TenantCloud\BetterReflection\Relocated\ReturnTypes\FooInterface
{
    return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\Foo();
}
/**
 * @return void
 */
function returnVoid()
{
    if (\rand(0, 1)) {
        return;
    }
    if (\rand(0, 1)) {
        return null;
    }
    if (\rand(0, 1)) {
        return 1;
    }
}
function returnAlias() : \TenantCloud\BetterReflection\Relocated\ReturnTypes\Foo
{
    return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\FooAlias();
}
function returnAnotherAlias() : \TenantCloud\BetterReflection\Relocated\ReturnTypes\FooAlias
{
    return new \TenantCloud\BetterReflection\Relocated\ReturnTypes\Foo();
}
/**
 * @return int
 */
function containsYield()
{
    (yield 1);
    return;
}
/**
 * @return mixed[]|string|null
 */
function returnUnionIterable()
{
    if (something()) {
        return 'foo';
    }
    return [];
}
/**
 * @param array<int, int> $arr
 */
function arrayMapConservesNonEmptiness(array $arr) : int
{
    if (!$arr) {
        return 5;
    }
    $arr = \array_map(function ($a) : int {
        return $a;
    }, $arr);
    return \array_shift($arr);
}
/**
 * @return \Generator<int, string>
 */
function returnFromGeneratorMixed() : \Generator
{
    (yield 1);
    return 2;
}
/**
 * @return \Generator<int, int, int, string>
 */
function returnFromGeneratorString() : \Generator
{
    (yield 1);
    if (\rand(0, 1)) {
        return;
    }
    return 2;
}
/**
 * @return \Generator<int, int, int, void>
 */
function returnVoidFromGenerator() : \Generator
{
    (yield 1);
    return;
}
/**
 * @return \Generator<int, int, int, void>
 */
function returnVoidFromGenerator2() : \Generator
{
    (yield 1);
    return 2;
}
/**
 * @return never
 */
function returnNever()
{
    return;
}
