<?php

namespace TenantCloud\BetterReflection\Relocated\TraitsReturnThis;

trait FooTrait
{
    /**
     * @return $this
     */
    public function returnsThisWithSelf() : self
    {
    }
    /**
     * @return $this
     */
    public function returnsThisWithFoo() : \TenantCloud\BetterReflection\Relocated\TraitsReturnThis\Foo
    {
    }
}
