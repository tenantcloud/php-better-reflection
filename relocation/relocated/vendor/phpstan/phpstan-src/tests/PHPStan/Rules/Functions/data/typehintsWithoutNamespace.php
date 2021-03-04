<?php

namespace TenantCloud\BetterReflection\Relocated;

class FooFunctionTypehints
{
}
trait SomeTraitWithoutNamespace
{
}
function fooWithoutNamespace(\TenantCloud\BetterReflection\Relocated\FooFunctionTypehints $foo, $bar, array $lorem) : \TenantCloud\BetterReflection\Relocated\NonexistentClass
{
}
function barWithoutNamespace(\TenantCloud\BetterReflection\Relocated\BarFunctionTypehints $bar) : array
{
}
function bazWithoutNamespace(...$bar) : \TenantCloud\BetterReflection\Relocated\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParentWithoutNamespace()
{
}
function badCaseTypehintsWithoutNamespace(\TenantCloud\BetterReflection\Relocated\fOOFunctionTypehints $foo) : \TenantCloud\BetterReflection\Relocated\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDocWithoutNamespace(\TenantCloud\BetterReflection\Relocated\FooFunctionTypehints $foo) : \TenantCloud\BetterReflection\Relocated\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDocWithoutNamespace(\TenantCloud\BetterReflection\Relocated\FOOFunctionTypehints $foo) : \TenantCloud\BetterReflection\Relocated\FOOFunctionTypehints
{
}
function referencesTraitsInNativeWithoutNamespace(\TenantCloud\BetterReflection\Relocated\SomeTraitWithoutNamespace $trait) : \TenantCloud\BetterReflection\Relocated\SomeTraitWithoutNamespace
{
}
/**
 * @param SomeTraitWithoutNamespace $trait
 * @return SomeTraitWithoutNamespace
 */
function referencesTraitsInPhpDocWithoutNamespace($trait)
{
}
