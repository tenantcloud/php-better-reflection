<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4343;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function (array $a) {
    if (\count($a) > 0) {
        $test = new \stdClass();
    }
    foreach ($a as $my) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $test);
    }
};
