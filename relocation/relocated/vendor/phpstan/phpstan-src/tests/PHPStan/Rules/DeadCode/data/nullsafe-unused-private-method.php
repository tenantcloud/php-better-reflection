<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NullsafeUnusedPrivateMethod;

class Foo
{
    public function doFoo(?self $self) : void
    {
        $self?->doBar();
    }
    private function doBar() : void
    {
    }
}
