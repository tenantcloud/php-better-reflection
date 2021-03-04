<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1283;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function (array $levels) : void {
    foreach ($levels as $level) {
        switch ($level) {
            case 'all':
                continue 2;
            case 'some':
                $allowedElements = array(1, 3);
                break;
            case 'one':
                $allowedElements = array(1);
                break;
            default:
                throw new \UnexpectedValueException(\sprintf('Unsupported level `%s`', $level));
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(0 => 1, ?1 => 3)', $allowedElements);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $allowedElements);
    }
};
