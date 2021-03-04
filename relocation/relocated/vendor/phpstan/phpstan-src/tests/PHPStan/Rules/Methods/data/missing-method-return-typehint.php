<?php

namespace TenantCloud\BetterReflection\Relocated\MissingMethodReturnTypehint;

interface FooInterface
{
    public function getFoo($p1);
}
class FooParent
{
    public function getBar($p2)
    {
    }
}
class Foo extends \TenantCloud\BetterReflection\Relocated\MissingMethodReturnTypehint\FooParent implements \TenantCloud\BetterReflection\Relocated\MissingMethodReturnTypehint\FooInterface
{
    public function getFoo($p1)
    {
    }
    /**
     * @param $p2
     */
    public function getBar($p2)
    {
    }
    public function getBaz() : bool
    {
        return \false;
    }
    /**
     * @return \stdClass|array|int|null
     */
    public function unionTypeWithUnknownArrayValueTypehint()
    {
    }
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
/**
 * @template A
 * @template B
 */
class GenericClass
{
}
class Bar
{
    public function returnsGenericInterface() : \TenantCloud\BetterReflection\Relocated\MissingMethodReturnTypehint\GenericInterface
    {
    }
    public function returnsNonGenericClass() : \TenantCloud\BetterReflection\Relocated\MissingMethodReturnTypehint\NonGenericClass
    {
    }
    public function returnsGenericClass() : \TenantCloud\BetterReflection\Relocated\MissingMethodReturnTypehint\GenericClass
    {
    }
}
class CallableSignature
{
    public function doFoo() : callable
    {
    }
}
