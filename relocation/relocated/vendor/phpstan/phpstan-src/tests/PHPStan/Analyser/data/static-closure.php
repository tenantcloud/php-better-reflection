<?php

namespace TenantCloud\BetterReflection\Relocated\StaticClosure;

class Foo
{
    public function doFoo() : void
    {
        static function () {
            die;
        };
    }
}
