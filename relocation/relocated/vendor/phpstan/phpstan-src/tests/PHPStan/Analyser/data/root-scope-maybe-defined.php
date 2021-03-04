<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $foo);
$bar = 'str';
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $bar);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $baz);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'str\'', $bar);
if (!isset($baz)) {
    $baz = 1;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', $baz);
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $baz);
function () {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo(), $foo);
};
