<?php

namespace TenantCloud\BetterReflection\Relocated\ShadowedTraitMethod;

trait FooTrait
{
    public function doFoo()
    {
        $this->doBar();
    }
}
class Foo
{
    use FooTrait;
    public function doFoo()
    {
    }
}
