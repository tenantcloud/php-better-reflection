<?php

namespace TenantCloud\BetterReflection\Relocated\TraitsCachingIssue;

use stdClass as Foo;
trait TraitTwo
{
    /**
     * @return Foo
     */
    public function doFoo()
    {
        return new \stdClass();
    }
}
