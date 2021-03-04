<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NullsafeMethodCallRule;

class Foo
{
    public function doFoo($mixed, ?\Exception $nullable, \Exception $nonNullable) : void
    {
        $mixed?->doFoo();
        $nullable?->doFoo();
        $nonNullable?->doFoo();
        null?->doFoo();
        // reported by a different rule
    }
}
