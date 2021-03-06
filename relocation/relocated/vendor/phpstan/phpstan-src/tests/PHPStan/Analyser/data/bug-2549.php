<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2549;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
class Pear
{
    public function doFoo() : void
    {
        $apples = [1, 2, 3];
        foreach ($apples as $apple) {
            $pear = null;
            switch (\true) {
                case \true:
                    $pear = new self();
                    break;
                default:
                    continue 2;
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug2549\\Pear', $pear);
        }
    }
    public function sayHello() : void
    {
        $array = [1, 2, 3];
        foreach ($array as $value) {
            switch ($value) {
                case 1:
                    $a = 2;
                    break;
                case 2:
                    $a = 3;
                    break;
                default:
                    continue 2;
            }
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('2|3', $a);
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
        }
    }
}
