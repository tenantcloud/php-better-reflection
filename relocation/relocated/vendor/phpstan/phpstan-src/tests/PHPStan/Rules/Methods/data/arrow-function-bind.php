<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind;

class Foo
{
    private function privateMethod()
    {
    }
    public function publicMethod()
    {
    }
}
class Bar
{
    public function fooMethod() : \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo
    {
        \Closure::bind(fn(\TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn(\TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->fooMethod(), $nonexistent, self::class);
        \Closure::bind(fn() => $this->barMethod(), $nonexistent, self::class);
        \Closure::bind(fn(\TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, 'TenantCloud\\BetterReflection\\Relocated\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, 'TenantCloud\\BetterReflection\\Relocated\\CallArrowFunctionBind\\Foo');
        \Closure::bind(fn(\TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo $foo) => $foo->privateMethod(), null, new \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo());
        \Closure::bind(fn(\TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo $foo) => $foo->nonexistentMethod(), null, new \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo());
        \Closure::bind(fn() => $this->privateMethod(), $this->fooMethod(), \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo::class);
        \Closure::bind(fn() => $this->nonexistentMethod(), $this->fooMethod(), \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo::class);
        (fn() => $this->publicMethod())->call(new \TenantCloud\BetterReflection\Relocated\CallArrowFunctionBind\Foo());
    }
}
class BazVoid
{
    public function doFoo() : void
    {
    }
    public function doBar() : void
    {
        $this->doBaz(fn() => $this->doFoo());
    }
    public function doBaz(callable $cb) : void
    {
    }
}
