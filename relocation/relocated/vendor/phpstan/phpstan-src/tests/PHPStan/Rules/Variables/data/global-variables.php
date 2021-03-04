<?php

namespace TenantCloud\BetterReflection\Relocated\GlobalVariables;

class Foo
{
    public function doFoo()
    {
        global $foo, $bar;
        echo $foo;
        echo $bar;
    }
}
