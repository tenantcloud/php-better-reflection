<?php

namespace TenantCloud\BetterReflection\Relocated\ConstInFunctions;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use const TenantCloud\BetterReflection\Relocated\CONDITIONAL;
const TABLE_NAME = 'resized_images';
\define('ANOTHER_NAME', 'foo');
\define('TenantCloud\\BetterReflection\\Relocated\\ConstInFunctions\\ANOTHER_NAME', 'bar');
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', TABLE_NAME);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'bar\'', ANOTHER_NAME);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', \TenantCloud\BetterReflection\Relocated\ConstInFunctions\TABLE_NAME);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'bar\'', \TenantCloud\BetterReflection\Relocated\ConstInFunctions\ANOTHER_NAME);
if (\rand(0, 1)) {
    \define('CONDITIONAL', \true);
} else {
    \define('CONDITIONAL', \false);
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \CONDITIONAL);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \CONDITIONAL);
function () {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', TABLE_NAME);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', \ANOTHER_NAME);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'bar\'', ANOTHER_NAME);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'resized_images\'', \TenantCloud\BetterReflection\Relocated\ConstInFunctions\TABLE_NAME);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'bar\'', \TenantCloud\BetterReflection\Relocated\ConstInFunctions\ANOTHER_NAME);
    if (\CONDITIONAL) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', \CONDITIONAL);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', \CONDITIONAL);
    } else {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \CONDITIONAL);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('false', \CONDITIONAL);
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \CONDITIONAL);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \CONDITIONAL);
};
