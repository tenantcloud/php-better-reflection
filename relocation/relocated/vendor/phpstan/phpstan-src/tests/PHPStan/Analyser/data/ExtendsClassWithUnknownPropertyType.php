<?php

namespace TenantCloud\BetterReflection\Relocated;

class ExtendsClassWithUnknownPropertyType extends \TenantCloud\BetterReflection\Relocated\ClassWithUnknownPropertyType
{
    /** @var self */
    private $foo;
    public function doFoo() : void
    {
        $this->foo->foo();
    }
}
