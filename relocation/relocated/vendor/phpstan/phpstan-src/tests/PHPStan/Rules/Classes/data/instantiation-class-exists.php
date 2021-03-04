<?php

namespace TenantCloud\BetterReflection\Relocated\InstantiationClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (\class_exists(\TenantCloud\BetterReflection\Relocated\InstantiationClassExists\Bar::class)) {
            $bar = new \TenantCloud\BetterReflection\Relocated\InstantiationClassExists\Bar();
        }
    }
}
