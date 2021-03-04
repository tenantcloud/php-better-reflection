<?php

namespace TenantCloud\BetterReflection\Relocated\ForeachWithGenericsPhpDoc;

class Foo
{
    /**
     * @param array<string, string|int|float> $list
     */
    public function doFoo(array $list)
    {
        foreach ($list as $key => $value) {
            die;
        }
    }
}
