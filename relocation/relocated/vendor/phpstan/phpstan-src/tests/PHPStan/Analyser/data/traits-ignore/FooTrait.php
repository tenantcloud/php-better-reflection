<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\TraitsIgnore;

trait FooTrait
{
    public function doFoo() : void
    {
        fail();
    }
}
