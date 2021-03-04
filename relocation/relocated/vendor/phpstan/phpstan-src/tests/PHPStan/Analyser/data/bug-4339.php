<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\Bug4339;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (?string $v) {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $v ?? '-');
    fn(?string $value): string => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $value ?? '-');
    fn(?string $value): void => \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $value);
    $f = fn(?string $value): string => $value ?? '-';
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $f($v));
};
