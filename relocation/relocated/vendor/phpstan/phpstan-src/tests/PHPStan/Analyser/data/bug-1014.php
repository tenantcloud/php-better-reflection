<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function bug1014() : void
{
    $s = \rand(0, 1) ? 0 : 1;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0|1', $s);
    if ($s) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $s);
        $s = 3;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('3', $s);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', $s);
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0|3', $s);
    if ($s === 1) {
    }
}
