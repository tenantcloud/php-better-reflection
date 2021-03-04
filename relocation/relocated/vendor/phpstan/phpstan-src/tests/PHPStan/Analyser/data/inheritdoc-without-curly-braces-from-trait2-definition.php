<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromTrait2;

trait FooTrait
{
    /**
     * @param string $string
     */
    public function doFoo($string)
    {
        die;
    }
}
