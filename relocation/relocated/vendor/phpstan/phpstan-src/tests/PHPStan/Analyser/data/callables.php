<?php

namespace TenantCloud\BetterReflection\Relocated\Callables;

class Foo
{
    public function doFoo() : float
    {
        $closure = function () : string {
        };
        $foo = $this;
        $arrayWithStaticMethod = ['TenantCloud\\BetterReflection\\Relocated\\Callables\\Foo', 'doBar'];
        $stringWithStaticMethod = 'Callables\\Foo::doFoo';
        $arrayWithInstanceMethod = [$this, 'doFoo'];
        die;
    }
    public function doBar() : \TenantCloud\BetterReflection\Relocated\Callables\Bar
    {
    }
    public function __invoke() : int
    {
    }
}
