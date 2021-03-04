<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NullsafeMethodCall;

class Foo
{
    public function doFoo(?self $selfOrNull) : void
    {
        $selfOrNull?->doBar();
        $selfOrNull?->doBar(1);
    }
    public function doBar() : void
    {
    }
    public function doBaz(&$passedByRef) : void
    {
    }
    public function doLorem(?self $selfOrNull) : void
    {
        $this->doBaz($selfOrNull?->test);
        $this->doBaz($selfOrNull?->test->test);
    }
}
