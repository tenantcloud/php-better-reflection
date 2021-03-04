<?php

namespace TenantCloud\BetterReflection\Relocated\TraitsReturnThis;

class Bar extends \TenantCloud\BetterReflection\Relocated\TraitsReturnThis\Foo
{
    public function doFoo() : void
    {
        (new \TenantCloud\BetterReflection\Relocated\TraitsReturnThis\Foo())->returnsThisWithSelf()->doFoo();
        (new \TenantCloud\BetterReflection\Relocated\TraitsReturnThis\Foo())->returnsThisWithFoo()->doFoo();
        (new \TenantCloud\BetterReflection\Relocated\TraitsReturnThis\Bar())->returnsThisWithSelf()->doFoo();
        (new \TenantCloud\BetterReflection\Relocated\TraitsReturnThis\Bar())->returnsThisWithFoo()->doFoo();
    }
}
