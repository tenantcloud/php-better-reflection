<?php

namespace TenantCloud\BetterReflection\Relocated\Analyser\Bug2443;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @param array<int,mixed> $a
 */
function (array $a) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \array_filter($a) !== []);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', [] !== \array_filter($a));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \array_filter($a) === []);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', [] === \array_filter($a));
};
