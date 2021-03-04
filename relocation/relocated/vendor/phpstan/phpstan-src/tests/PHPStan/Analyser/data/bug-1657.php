<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1657;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @param string|int $value
 */
function foo($value)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string', $value);
    try {
        \assert(\is_string($value));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $value);
    } catch (\Throwable $e) {
        $value = 'A';
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'A\'', $value);
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $value);
}
