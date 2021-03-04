<?php

namespace TenantCloud\BetterReflection\Relocated\StaticMethodsClassExists;

use function class_exists;
class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\TenantCloud\BetterReflection\Relocated\StaticMethodsClassExists\Bar::class)) {
            return;
        }
        \TenantCloud\BetterReflection\Relocated\StaticMethodsClassExists\Bar::doBar();
    }
}
