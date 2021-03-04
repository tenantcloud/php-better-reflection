<?php

namespace TenantCloud\BetterReflection\Relocated\BaselineIntegration;

class Foo
{
    use FooTrait;
    public function doFoo() : int
    {
        return 'string';
    }
}
