<?php

namespace TenantCloud\BetterReflection\Relocated\OverridenMethodPrototype;

class Foo
{
    protected function foo()
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\OverridenMethodPrototype\Foo
{
    public function foo()
    {
    }
}
function () {
    $bar = new \TenantCloud\BetterReflection\Relocated\OverridenMethodPrototype\Bar();
    $bar->foo();
};
