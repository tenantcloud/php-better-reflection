<?php

namespace TenantCloud\BetterReflection\Relocated\ConditionalNonEmptyArray;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
class Foo
{
    public function doFoo(array $a) : void
    {
        foreach ($a as $val) {
            $foo = 1;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
        if (\count($a) > 0) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array&nonEmpty', $a);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $foo);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array()', $a);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
        }
    }
}
