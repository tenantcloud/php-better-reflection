<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\ThrowExpr;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(bool $b) : void
    {
        $result = $b ? \true : throw new \Exception();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $result);
    }
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', throw new \Exception());
    }
}
