<?php

namespace TenantCloud\BetterReflection\Relocated;

function globalFunction1($a, $b, $c)
{
    return \false;
}
function globalFunction2($a, $b, $c) : bool
{
    $closure = function ($a, $b, $c) {
    };
    return \false;
}
/**
 * @return bool
 */
function globalFunction3($a, $b, $c)
{
    return \false;
}
namespace TenantCloud\BetterReflection\Relocated\MissingFunctionReturnTypehint;

function namespacedFunction1($d, $e)
{
    return 9;
}
function namespacedFunction2($d, $e) : int
{
    return 9;
}
/**
 * @return int
 */
function namespacedFunction3($d, $e)
{
    return 9;
}
/**
 * @return \stdClass|array|int|null
 */
function unionTypeWithUnknownArrayValueTypehint()
{
}
/**
 * @template T
 * @template U
 */
interface GenericInterface
{
}
class NonGenericClass
{
}
function returnsGenericInterface() : \TenantCloud\BetterReflection\Relocated\MissingFunctionReturnTypehint\GenericInterface
{
}
function returnsNonGenericClass() : \TenantCloud\BetterReflection\Relocated\MissingFunctionReturnTypehint\NonGenericClass
{
}
/**
 * @template A
 * @template B
 */
class GenericClass
{
}
function returnsGenericClass() : \TenantCloud\BetterReflection\Relocated\MissingFunctionReturnTypehint\GenericClass
{
}
/**
 * @return GenericClass<GenericClass<int, int>, GenericClass<int, int>>
 */
function genericGenericValidArgs() : \TenantCloud\BetterReflection\Relocated\MissingFunctionReturnTypehint\GenericClass
{
}
/**
 * @return GenericClass<GenericClass, int>
 */
function genericGenericMissingTemplateArgs() : \TenantCloud\BetterReflection\Relocated\MissingFunctionReturnTypehint\GenericClass
{
}
/**
 * @return \Closure
 */
function closureWithNoPrototype() : \Closure
{
}
/**
 * @return \Closure(int) : void
 */
function closureWithPrototype() : \Closure
{
}
/**
 * @return callable
 */
function callableWithNoPrototype() : callable
{
}
/**
 * @return callable(int) : void
 */
function callableWithPrototype() : callable
{
}
/**
 * @return callable(callable) : void
 */
function callableNestedNoPrototype() : callable
{
}
/**
 * @return callable(callable(int) : void) : void
 */
function callableNestedWithPrototype() : callable
{
}
