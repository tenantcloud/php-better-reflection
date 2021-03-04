<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromInterface2;

class Foo implements \TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromInterface2\FooInterface
{
    /**
     * @inheritdoc
     */
    public function doBar($int)
    {
        die;
    }
}
