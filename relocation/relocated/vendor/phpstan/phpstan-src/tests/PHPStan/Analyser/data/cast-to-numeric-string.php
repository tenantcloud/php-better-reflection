<?php

namespace TenantCloud\BetterReflection\Relocated\CastToNumericString;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @param int|float|numeric-string $numeric
 * @param numeric $numeric2
 * @param number $number
 * @param positive-int $positive
 * @param negative-int $negative
 * @param 1 $constantInt
 */
function foo(int $a, float $b, $numeric, $numeric2, $number, $positive, $negative, $constantInt) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', (string) $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', (string) $b);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', (string) $numeric);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', (string) $numeric2);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', (string) $number);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', (string) $positive);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', (string) $negative);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'1'", (string) $constantInt);
}
/**
 * @param int|float|numeric-string $numeric
 * @param numeric $numeric2
 * @param number $number
 * @param positive-int $positive
 * @param negative-int $negative
 * @param 1 $constantInt
 */
function concatEmptyString(int $a, float $b, $numeric, $numeric2, $number, $positive, $negative, $constantInt) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', '' . $a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', '' . $b);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', '' . $numeric);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', '' . $numeric2);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', '' . $number);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', '' . $positive);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', '' . $negative);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'1'", '' . $constantInt);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $a . '');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $b . '');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $numeric . '');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $numeric2 . '');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $number . '');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $positive . '');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $negative . '');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'1'", $constantInt . '');
}
function concatAssignEmptyString(int $i, float $f)
{
    $i .= '';
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $i);
    $s = '';
    $s .= $f;
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string&numeric', $s);
}
