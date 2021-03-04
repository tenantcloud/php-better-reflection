<?php

namespace TenantCloud\BetterReflection\Relocated\App\Foo;

use function TenantCloud\BetterReflection\Relocated\PHPStan\dumpType;
function (array $a) {
    if ($a === []) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\dumpType($a);
    \TenantCloud\BetterReflection\Relocated\PHPStan\dumpType($a);
};
