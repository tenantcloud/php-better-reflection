<?php

namespace TenantCloud\BetterReflection\Relocated\ShadowedTraitMethods;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
trait FooTrait
{
    public function doFoo()
    {
        $a = 1;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('foo', $a);
        // doesn't get evaluated
    }
}
trait BarTrait
{
    use FooTrait;
    public function doFoo()
    {
        $a = 2;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2', $a);
    }
}
class Foo
{
    use BarTrait;
}
