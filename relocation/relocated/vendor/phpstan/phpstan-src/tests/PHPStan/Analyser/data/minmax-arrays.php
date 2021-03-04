<?php

namespace TenantCloud\BetterReflection\Relocated\MinMaxArrays;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function dummy() : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', \min([1]));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \min([]));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', \max([1]));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \max([]));
}
/**
 * @param int[] $ints
 */
function dummy2(array $ints) : void
{
    if (\count($ints) === 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) === 1) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \max($ints));
    }
    if (\count($ints) !== 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \max($ints));
    }
    if (\count($ints) !== 1) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) > 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \max($ints));
    }
    if (\count($ints) >= 1) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \max($ints));
    }
    if (\count($ints) >= 2) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \max($ints));
    }
    if (\count($ints) <= 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) < 1) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    }
    if (\count($ints) < 2) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \max($ints));
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \min($ints));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \max($ints));
    }
}
/**
 * @param int[] $ints
 */
function dummy3(array $ints) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \min($ints));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|false', \max($ints));
}
function dummy4(\DateTimeInterface $dateA, ?\DateTimeInterface $dateB) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(0 => DateTimeInterface, ?1 => DateTimeInterface)', \array_filter([$dateA, $dateB]));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', \min(\array_filter([$dateA, $dateB])));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface', \max(\array_filter([$dateA, $dateB])));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?0 => DateTimeInterface)', \array_filter([$dateB]));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface|false', \min(\array_filter([$dateB])));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DateTimeInterface|false', \max(\array_filter([$dateB])));
}
function dummy5(int $i, int $j) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?0 => int<min, -1>|int<1, max>, ?1 => int<min, -1>|int<1, max>)', \array_filter([$i, $j]));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(1 => true)', \array_filter([\false, \true]));
}
function dummy6(string $s, string $t) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(?0 => string, ?1 => string)', \array_filter([$s, $t]));
}
