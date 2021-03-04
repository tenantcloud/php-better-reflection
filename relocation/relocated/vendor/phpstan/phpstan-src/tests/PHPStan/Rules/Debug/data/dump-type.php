<?php

namespace TenantCloud\BetterReflection\Relocated\PHPStan;

function (array $a) {
    if ($a === []) {
        return;
    }
    dumpType($a);
    dumpType();
};
