<?php

namespace TenantCloud\BetterReflection\Relocated\InnerFunctions;

function foo()
{
    function bar()
    {
    }
}
class Foo
{
    public function doFoo()
    {
        function anotherFoo()
        {
        }
    }
}
