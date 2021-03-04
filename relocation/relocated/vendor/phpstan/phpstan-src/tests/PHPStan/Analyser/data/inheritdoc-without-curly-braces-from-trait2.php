<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromTrait2;

class Foo extends \TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromTrait2\FooParent
{
    /**
     * @inheritdoc
     */
    public function doFoo($string)
    {
        die;
    }
}
