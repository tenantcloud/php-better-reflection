<?php

namespace TenantCloud\BetterReflection\Relocated;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
const TABLE_NAME = 'resized_images';
\define('ANOTHER_NAME', 'foo');
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
function () {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', \TABLE_NAME);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
};
