<?php

namespace TenantCloud\BetterReflection\Relocated\CallClosureBind;

class Bar
{
    public function fooMethod() : \TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo
    {
        \Closure::bind(function (\TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, \TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo::class);
        $this->fooMethod();
        $this->barMethod();
        $foo = new \TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo();
        $foo->privateMethod();
        $foo->nonexistentMethod();
        \Closure::bind(function () {
            $this->fooMethod();
            $this->barMethod();
        }, $nonexistent, self::class);
        \Closure::bind(function (\TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, 'TenantCloud\\BetterReflection\\Relocated\\CallClosureBind\\Foo');
        \Closure::bind(function (\TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo $foo) {
            $foo->privateMethod();
            $foo->nonexistentMethod();
        }, null, new \TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo());
        \Closure::bind(function () {
            // $this is Foo
            $this->privateMethod();
            $this->nonexistentMethod();
        }, $this->fooMethod(), \TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo::class);
        (function () {
            $this->publicMethod();
        })->call(new \TenantCloud\BetterReflection\Relocated\CallClosureBind\Foo());
    }
}
