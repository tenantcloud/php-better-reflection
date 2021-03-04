<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NullsafeMethodCallNoSideEffects;

class Foo
{
    public function doFoo(?\Exception $e) : void
    {
        $e?->getMessage();
    }
}
