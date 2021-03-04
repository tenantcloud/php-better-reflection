<?php

namespace TenantCloud\BetterReflection\Relocated\CatchWithoutVariable;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : void
    {
        try {
        } catch (\TenantCloud\BetterReflection\Relocated\FooException) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*ERROR*', $e);
        }
    }
}
