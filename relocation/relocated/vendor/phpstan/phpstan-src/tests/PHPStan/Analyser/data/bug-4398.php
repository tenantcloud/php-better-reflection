<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4398;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (array $meters) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', $meters);
    if (empty($meters)) {
        throw new \Exception('NO_METERS_FOUND');
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array&nonEmpty', $meters);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array', \array_reverse());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array&nonEmpty', \array_reverse($meters));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, (int|string)>&nonEmpty', \array_keys($meters));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, mixed>&nonEmpty', \array_values($meters));
};
