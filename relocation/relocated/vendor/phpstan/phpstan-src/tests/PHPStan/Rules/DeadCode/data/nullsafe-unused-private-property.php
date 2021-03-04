<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NullsafeUnusedPrivateProperty;

class Foo
{
    private string $bar = 'foo';
    public function doFoo(?self $self) : void
    {
        echo $self?->bar;
    }
}
