<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocFromTrait2;

class Foo extends \TenantCloud\BetterReflection\Relocated\InheritDocFromTrait2\FooParent
{
    /**
     * {@inheritdoc}
     */
    public function doFoo($string)
    {
        die;
    }
}
