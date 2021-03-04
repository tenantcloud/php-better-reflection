<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2816;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
if (isset($_GET['x'])) {
    $a = 1;
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $a);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $a);
if (isset($a) === \true) {
    echo "hello";
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~null', $a);
} else {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $a);
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $a);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $a);
if (isset($a) === \true) {
    echo "hello2";
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~null', $a);
} else {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $a);
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $a);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $a);
