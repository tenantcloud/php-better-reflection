<?php

namespace TenantCloud\BetterReflection\Relocated\Analyser\Bug2954;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (int $x) {
    if ($x === 0) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>|int<1, max>', $x);
    $x++;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $x);
};
function (int $x) {
    if ($x === 0) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>|int<1, max>', $x);
    ++$x;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $x);
};
function (int $x) {
    if ($x === 0) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>|int<1, max>', $x);
    $x--;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $x);
};
function (int $x) {
    if ($x === 0) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>|int<1, max>', $x);
    --$x;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $x);
};
