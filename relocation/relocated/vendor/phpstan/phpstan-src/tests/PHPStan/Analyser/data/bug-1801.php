<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1801;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty;
function demo() : string
{
    try {
        $response = 'OK';
    } catch (\Throwable $e) {
        $response = 'ERROR';
    } finally {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertVariableCertainty(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), $response);
        return $response;
    }
}
