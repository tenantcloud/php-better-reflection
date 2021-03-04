<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4505;

class Foo
{
    public function doFoo() : void
    {
        if (\true) {
            return;
        }
        /** @var int $foobar */
        $foobar = 1;
    }
}
