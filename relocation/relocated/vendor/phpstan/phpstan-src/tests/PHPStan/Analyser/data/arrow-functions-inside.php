<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\ArrowFunctionsInside;

class Foo
{
    public function doFoo(int $i)
    {
        fn(string $s) => die;
    }
}
