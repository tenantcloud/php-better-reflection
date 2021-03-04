<?php

namespace TenantCloud\BetterReflection\Relocated\ForeachWithComplexValueType;

class Foo
{
    /**
     * @param iterable<float|self> $list
     */
    public function doFoo(iterable $list)
    {
        foreach ($list as $value) {
            die;
        }
    }
}
