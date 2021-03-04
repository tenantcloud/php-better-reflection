<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4207;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function () : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, int>&nonEmpty', \range(1, 10000));
};
