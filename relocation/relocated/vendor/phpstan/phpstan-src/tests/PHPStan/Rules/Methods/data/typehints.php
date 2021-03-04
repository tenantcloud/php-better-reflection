<?php

namespace TenantCloud\BetterReflection\Relocated\TestMethodTypehints;

class FooMethodTypehints
{
    function foo(\TenantCloud\BetterReflection\Relocated\TestMethodTypehints\FooMethodTypehints $foo, $bar, array $lorem) : \TenantCloud\BetterReflection\Relocated\TestMethodTypehints\NonexistentClass
    {
    }
    function bar(\TenantCloud\BetterReflection\Relocated\TestMethodTypehints\BarMethodTypehints $bar) : array
    {
    }
    function baz(...$bar) : \TenantCloud\BetterReflection\Relocated\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints[] $foos
     * @param BarMethodTypehints[] $bars
     * @return BazMethodTypehints[]
     */
    function lorem($foos, $bars)
    {
    }
    /**
     * @param FooMethodTypehints[] $foos
     * @param BarMethodTypehints[] $bars
     * @return BazMethodTypehints[]
     */
    function ipsum(array $foos, array $bars) : array
    {
    }
    /**
     * @param FooMethodTypehints[] $foos
     * @param FooMethodTypehints|BarMethodTypehints[] $bars
     * @return self|BazMethodTypehints[]
     */
    function dolor(array $foos, array $bars) : array
    {
    }
    function parentWithoutParent(parent $parent) : \TenantCloud\BetterReflection\Relocated\parent
    {
    }
    /**
     * @param parent $parent
     * @return parent
     */
    function phpDocParentWithoutParent($parent)
    {
    }
    function badCaseTypehints(\TenantCloud\BetterReflection\Relocated\TestMethodTypehints\fOOMethodTypehints $foo) : \TenantCloud\BetterReflection\Relocated\TestMethodTypehints\fOOMethodTypehintS
    {
    }
    /**
     * @param fOOMethodTypehints|\STDClass $foo
     * @return fOOMethodTypehintS|\stdclass
     */
    function unionTypeBadCaseTypehints($foo)
    {
    }
    /**
     * @param FOOMethodTypehints $foo
     * @return FOOMethodTypehints
     */
    function badCaseInNativeAndPhpDoc(\TenantCloud\BetterReflection\Relocated\TestMethodTypehints\FooMethodTypehints $foo) : \TenantCloud\BetterReflection\Relocated\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints $foo
     * @return FooMethodTypehints
     */
    function anotherBadCaseInNativeAndPhpDoc(\TenantCloud\BetterReflection\Relocated\TestMethodTypehints\FOOMethodTypehints $foo) : \TenantCloud\BetterReflection\Relocated\TestMethodTypehints\FOOMethodTypehints
    {
    }
    /**
     * @param array<NonexistentClass, AnotherNonexistentClass> $array
     */
    function unknownTypesInArrays(array $array)
    {
    }
}
class CallableTypehints
{
    /** @param callable(Bla): Ble $cb */
    public function doFoo(callable $cb) : void
    {
    }
}
/**
 * @template T
 */
class TemplateTypeMissingInParameter
{
    /**
     * @template U of object
     * @param class-string $class
     */
    public function doFoo(string $class) : void
    {
    }
    /**
     * @template U of object
     * @param class-string<U> $class
     */
    public function doBar(string $class) : void
    {
    }
}
