<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NullsafePropertyFetchRule;

class Foo
{
    public function doFoo($mixed, ?\Exception $nullable, \Exception $nonNullable) : void
    {
        $mixed?->foo;
        $nullable?->foo;
        $nonNullable?->foo;
        null?->foo;
        // reported by a different rule
    }
}
