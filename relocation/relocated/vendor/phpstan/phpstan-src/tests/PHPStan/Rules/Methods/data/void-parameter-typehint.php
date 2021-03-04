<?php

namespace TenantCloud\BetterReflection\Relocated\VoidParameterTypehintMethod;

class Foo
{
    public function doFoo(void $param) : int
    {
        return 1;
    }
}
