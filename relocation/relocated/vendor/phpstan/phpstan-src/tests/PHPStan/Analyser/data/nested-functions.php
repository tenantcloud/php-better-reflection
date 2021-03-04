<?php

namespace TenantCloud\BetterReflection\Relocated\NestedFunctions;

class Foo
{
    public function doFoo() : self
    {
        return $this;
    }
}
function () {
    $foo = new \TenantCloud\BetterReflection\Relocated\NestedFunctions\Foo();
    $foo->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo()->doFoo();
};
