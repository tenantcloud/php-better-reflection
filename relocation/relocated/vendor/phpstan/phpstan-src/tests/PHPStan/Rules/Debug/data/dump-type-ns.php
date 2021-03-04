<?php

namespace TenantCloud\BetterReflection\Relocated\App\Foo;

function (array $a) {
    if ($a === []) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\dumpType($a);
    dumpType($a);
};
