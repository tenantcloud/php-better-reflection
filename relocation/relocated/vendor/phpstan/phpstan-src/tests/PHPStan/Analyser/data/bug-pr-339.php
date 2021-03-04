<?php

namespace TenantCloud\BetterReflection\Relocated\BugPr339;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $a);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $c);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $a);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $c);
if ($a || $c) {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe(), $c);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $c);
    if ($a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("mixed~0|0.0|''|'0'|array()|false|null", $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $c);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $a);
    }
    if ($c) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $a);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("mixed~0|0.0|''|'0'|array()|false|null", $c);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $c);
    }
} else {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("0|0.0|''|'0'|array()|false|null", $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("0|0.0|''|'0'|array()|false|null", $c);
}
