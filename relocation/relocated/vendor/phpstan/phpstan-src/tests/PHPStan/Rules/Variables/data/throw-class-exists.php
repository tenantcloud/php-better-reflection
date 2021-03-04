<?php

namespace TenantCloud\BetterReflection\Relocated\ThrowClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\TenantCloud\BetterReflection\Relocated\ThrowClassExists\Bar::class)) {
            return;
        }
        throw new \TenantCloud\BetterReflection\Relocated\ThrowClassExists\Bar();
    }
}
