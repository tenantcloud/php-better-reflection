<?php

namespace TenantCloud\BetterReflection\Relocated;

function () {
    /** @var int|string $s */
    $s = \TenantCloud\BetterReflection\Relocated\doFoo();
    if (!\is_numeric($s)) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $s);
    }
};
