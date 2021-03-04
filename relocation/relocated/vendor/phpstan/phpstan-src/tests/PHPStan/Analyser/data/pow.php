<?php

namespace TenantCloud\BetterReflection\Relocated\PowFunction;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function ($a, $b) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(float|int)', \pow($a, $b));
};
function (int $a, int $b) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(float|int)', \pow($a, $b));
};
function (\GMP $a, \GMP $b) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('GMP', \pow($a, $b));
};
function (\stdClass $a, \GMP $b) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('GMP|stdClass', \pow($a, $b));
};
