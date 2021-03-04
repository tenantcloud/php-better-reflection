<?php

namespace TenantCloud\BetterReflection\Relocated\MissingReturnTemplateMixedType;

class Foo
{
    /**
     * @template T
     * @param T $a
     * @return T
     */
    public function doFoo($a)
    {
    }
}
