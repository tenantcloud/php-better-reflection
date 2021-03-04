<?php

namespace TenantCloud\BetterReflection\Relocated\ArrowFunctionReturnTypeInference;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (int $i) : void {
    $fn = fn() => $i;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $fn());
};
function (int $i) : void {
    $fn = fn(): string => $i;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $fn());
};
