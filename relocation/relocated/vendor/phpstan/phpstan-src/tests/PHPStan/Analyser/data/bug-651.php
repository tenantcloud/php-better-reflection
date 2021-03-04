<?php

namespace TenantCloud\BetterReflection\Relocated\Bug651;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function () : void {
    foreach (['foo', 'bar'] as $loopValue) {
        switch ($loopValue) {
            case 'foo':
                continue 2;
            case 'bar':
                $variableDefinedWithinForeach = 23;
                break;
            default:
                throw new \LogicException();
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('23', $variableDefinedWithinForeach);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $variableDefinedWithinForeach);
        echo $variableDefinedWithinForeach;
    }
};
