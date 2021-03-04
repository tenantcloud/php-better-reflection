<?php

namespace TenantCloud\BetterReflection\Relocated\PHPStan\Generics\GenericClassStringType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (int $i) {
    if ($i < 3) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 2>', $i);
        $i++;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 3>', $i);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<3, max>', $i);
    }
    if ($i < 3) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 2>', $i);
        $i--;
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 1>', $i);
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 1>|int<3, max>', $i);
    if ($i < 3 && $i > 5) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $i);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 1>|int<3, max>', $i);
    }
    if ($i > 3 && $i < 5) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('4', $i);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('3|int<min, 1>|int<5, max>', $i);
    }
    if ($i >= 3 && $i <= 5) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<3, 5>', $i);
        if ($i === 2) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $i);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<3, 5>', $i);
        }
        if ($i !== 3) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<4, 5>', $i);
        } else {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('3', $i);
        }
    }
};
function () {
    for ($i = 0; $i < 5; $i++) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 4>', $i);
        // should improved to be int<0, 4>
    }
    $i = 0;
    while ($i < 5) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 4>', $i);
        // should improved to be int<0, 4>
        $i++;
    }
    $i = 0;
    while ($i++ < 5) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 5>', $i);
        // should improved to be int<1, 5>
    }
    $i = 0;
    while (++$i < 5) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 4>', $i);
        // should improved to be int<1, 4>
    }
    $i = 5;
    while ($i-- > 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $i);
        // should improved to be int<0, 4>
    }
    $i = 5;
    while (--$i > 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $i);
        // should improved to be int<1, 4>
    }
};
function (int $j) {
    $i = 1;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $i > 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $i >= 1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $i <= 1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $i < 2);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $i < 1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $i <= 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $i >= 2);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $i > 1);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 0 < $i);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 1 <= $i);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 1 >= $i);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 2 > $i);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j > 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j >= 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j <= 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j < 0);
    if ($j < 5) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j > 0);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $j > 4);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', 0 < $j);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 4 < $j);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j >= 0);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', $j >= 5);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', 0 <= $j);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', 5 <= $j);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $j <= 4);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j <= 3);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 4 >= $j);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', 3 >= $j);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $j < 5);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $j < 4);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', 5 > $j);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', 4 > $j);
    }
};
function (int $a, int $b, int $c) : void {
    if ($a <= 11) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<12, max>', $a);
    if ($b <= 12) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<13, max>', $b);
    if ($c <= 13) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<14, max>', $c);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a * $b);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $b * $c);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $a * $b * $c);
};
