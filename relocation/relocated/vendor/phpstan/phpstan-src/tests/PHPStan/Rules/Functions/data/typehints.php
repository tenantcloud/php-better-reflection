<?php

namespace TenantCloud\BetterReflection\Relocated\TestFunctionTypehints;

class FooFunctionTypehints
{
}
trait SomeTrait
{
}
function foo(\TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : \TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\NonexistentClass
{
}
function bar(\TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\BarFunctionTypehints $bar) : array
{
}
function baz(...$bar) : \TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParent()
{
}
function badCaseTypehints(\TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\fOOFunctionTypehints $foo) : \TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDoc(\TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\FooFunctionTypehints $foo) : \TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDoc(\TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\FOOFunctionTypehints $foo) : \TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\FOOFunctionTypehints
{
}
function referencesTraitsInNative(\TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\SomeTrait $trait) : \TenantCloud\BetterReflection\Relocated\TestFunctionTypehints\SomeTrait
{
}
/**
 * @param SomeTrait $trait
 * @return SomeTrait
 */
function referencesTraitsInPhpDoc($trait)
{
}
/**
 * @param class-string<SomeNonexistentClass> $string
 */
function genericClassString(string $string)
{
}
/**
 * @template T of SomeNonexistentClass
 * @param class-string<T> $string
 */
function genericTemplateClassString(string $string)
{
}
/**
 * @template T
 * @param class-string $a
 */
function templateTypeMissingInParameter(string $a)
{
}
