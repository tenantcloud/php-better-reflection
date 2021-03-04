<?php

namespace TenantCloud\BetterReflection\Relocated\ForeachWithComplexValueType;

class Foo
{
    /**
     * @param (float|self)[] $list
     */
    public function doFoo(array $list)
    {
        foreach ($list as $value) {
            die;
        }
    }
}
