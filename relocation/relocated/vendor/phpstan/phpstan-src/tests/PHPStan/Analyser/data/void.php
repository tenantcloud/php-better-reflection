<?php

namespace TenantCloud\BetterReflection\Relocated\VoidNamespace;

class Foo
{
    public function doFoo() : void
    {
        die;
    }
    /**
     * @return void
     */
    public function doBar() : void
    {
    }
    /**
     * @return int
     */
    public function doConflictingVoid() : void
    {
    }
}
