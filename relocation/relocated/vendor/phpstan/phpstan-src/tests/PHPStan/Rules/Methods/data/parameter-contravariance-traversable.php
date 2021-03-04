<?php

namespace TenantCloud\BetterReflection\Relocated\ParameterContravarianceTraversable;

class Foo
{
    public function doFoo(\Traversable $a)
    {
    }
    public function doBar(?\Traversable $a)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\ParameterContravarianceTraversable\Foo
{
    public function doFoo(iterable $a)
    {
    }
    public function doBar(?iterable $a)
    {
    }
}
class Baz extends \TenantCloud\BetterReflection\Relocated\ParameterContravarianceTraversable\Foo
{
    public function doFoo(?iterable $a)
    {
    }
    public function doBar(iterable $a)
    {
    }
}
