<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NullsafePropertyFetchNoop;

class Foo
{
    public function doFoo(?\ReflectionClass $ref) : void
    {
        $ref?->name;
    }
}
