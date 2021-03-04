<?php

namespace TenantCloud\BetterReflection\Relocated\TypesNamespaceCastUnset;

class Foo
{
    public function doFoo()
    {
        $castedNull = (unset) foo();
        die;
    }
}
