<?php

namespace TenantCloud\BetterReflection\Relocated\StaticPropertiesClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\TenantCloud\BetterReflection\Relocated\StaticPropertiesClassExists\Bar::class)) {
            return;
        }
        echo \TenantCloud\BetterReflection\Relocated\StaticPropertiesClassExists\Bar::$foo;
    }
}
