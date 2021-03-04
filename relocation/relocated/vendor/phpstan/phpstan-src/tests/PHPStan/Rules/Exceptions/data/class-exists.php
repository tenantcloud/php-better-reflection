<?php

namespace TenantCloud\BetterReflection\Relocated\CaughtExceptionClassExists;

class Foo
{
    public function doFoo() : void
    {
        if (!\class_exists(\TenantCloud\BetterReflection\Relocated\CaughtExceptionClassExists\FooException::class)) {
            return;
        }
        try {
        } catch (\TenantCloud\BetterReflection\Relocated\CaughtExceptionClassExists\FooException $e) {
        }
    }
}
