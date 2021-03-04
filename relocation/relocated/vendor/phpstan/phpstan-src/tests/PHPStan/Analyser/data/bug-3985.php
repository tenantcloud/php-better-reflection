<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3985;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
class Foo
{
    public function doFoo(array $array) : void
    {
        foreach ($array as $val) {
            if (isset($foo[1])) {
                \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
            }
        }
    }
    public function doBar() : void
    {
        if (isset($foo[1])) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
        }
    }
}
