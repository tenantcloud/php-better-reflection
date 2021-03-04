<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4205;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function () {
    $result = \set_error_handler(function () {
    }, \E_ALL);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('(callable(): mixed)|null', $result);
};
