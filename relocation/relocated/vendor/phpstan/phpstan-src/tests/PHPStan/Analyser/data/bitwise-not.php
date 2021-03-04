<?php

namespace TenantCloud\BetterReflection\Relocated\BitwiseNot;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @param string|int $stringOrInt
 */
function foo(int $int, string $string, float $float, $stringOrInt) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', ~$int);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', ~$string);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', ~$float);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string', ~$stringOrInt);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'" . ~"abc" . "'", ~"abc");
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', ~1);
    //result is dependent on PHP_INT_SIZE
}
