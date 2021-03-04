<?php

namespace TenantCloud\BetterReflection\Relocated;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (int $min) {
    \assert($min === 10 || $min === 15);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<10, 20>', \random_int($min, 20));
};
function (int $min) {
    \assert($min <= 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 20>', \random_int($min, 20));
};
function (int $max) {
    \assert($min >= 0);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \random_int(0, $max));
};
function (int $i) {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \random_int($i, $i));
};
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', \random_int(0, 0));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \random_int(\PHP_INT_MIN, \PHP_INT_MAX));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \random_int(0, \PHP_INT_MAX));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<min, 0>', \random_int(\PHP_INT_MIN, 0));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-1, 1>', \random_int(-1, 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, 30>', \random_int(0, \random_int(0, 30)));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, 100>', \random_int(\random_int(0, 10), 100));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', \random_int(10, 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', \random_int(2, \random_int(0, 1)));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, 1>', \random_int(0, \random_int(0, 1)));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', \random_int(\random_int(0, 1), -1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, 1>', \random_int(\random_int(0, 1), 1));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<-5, 5>', \random_int(\random_int(-5, 0), \random_int(0, 5)));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \random_int(\random_int(\PHP_INT_MIN, 0), \random_int(0, \PHP_INT_MAX)));
