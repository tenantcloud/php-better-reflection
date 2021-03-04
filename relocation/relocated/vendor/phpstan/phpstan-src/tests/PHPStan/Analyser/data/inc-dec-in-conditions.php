<?php

namespace TenantCloud\BetterReflection\Relocated\IncDecInConditions;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function incLeft(int $a, int $b, int $c, int $d) : void
{
    if (++$a < 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $a);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $a);
    }
    if (++$b <= 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>', $b);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $b);
    }
    if ($c++ < 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>', $c);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $c);
    }
    if ($d++ <= 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 1>', $d);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<2, max>', $d);
    }
}
function incRight(int $a, int $b, int $c, int $d) : void
{
    if (0 < ++$a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $a);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>', $a);
    }
    if (0 <= ++$b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $b);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $b);
    }
    if (0 < $c++) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<2, max>', $c);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 1>', $c);
    }
    if (0 <= $d++) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $d);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>', $d);
    }
}
function decLeft(int $a, int $b, int $c, int $d) : void
{
    if (--$a < 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $a);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $a);
    }
    if (--$b <= 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>', $b);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $b);
    }
    if ($c-- < 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -2>', $c);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-1, max>', $c);
    }
    if ($d-- <= 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $d);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $d);
    }
}
function decRight(int $a, int $b, int $c, int $d) : void
{
    if (0 < --$a) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<1, max>', $a);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>', $a);
    }
    if (0 <= --$b) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $b);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $b);
    }
    if (0 < $c--) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $c);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -1>', $c);
    }
    if (0 <= $d--) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-1, max>', $d);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, -2>', $d);
    }
}
