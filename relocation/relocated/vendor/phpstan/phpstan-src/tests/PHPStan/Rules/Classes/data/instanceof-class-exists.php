<?php

namespace TenantCloud\BetterReflection\Relocated\InstanceofClassExists;

class Foo
{
    public function doFoo() : void
    {
        /** @var object $object */
        $object = doFoo();
        \class_exists(\TenantCloud\BetterReflection\Relocated\InstanceofClassExists\Bar::class) ? $object instanceof \TenantCloud\BetterReflection\Relocated\InstanceofClassExists\Bar : \false;
    }
}
