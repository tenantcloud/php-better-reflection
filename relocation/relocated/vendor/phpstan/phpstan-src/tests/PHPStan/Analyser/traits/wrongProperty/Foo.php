<?php

namespace TenantCloud\BetterReflection\Relocated\TraitsWrongProperty;

use TenantCloud\BetterReflection\Relocated\Lorem as Bar;
class Foo
{
    use FooTrait;
    public function doFoo() : void
    {
        $this->id = 1;
        $this->id = 'foo';
        $this->bar = 1;
    }
}
