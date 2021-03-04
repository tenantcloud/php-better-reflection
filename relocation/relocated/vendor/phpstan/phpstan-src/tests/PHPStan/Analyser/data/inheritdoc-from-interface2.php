<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocFromInterface2;

class Foo implements \TenantCloud\BetterReflection\Relocated\InheritDocFromInterface2\FooInterface
{
    /**
     * {@inheritdoc}
     */
    public function doBar($int)
    {
        die;
    }
}
