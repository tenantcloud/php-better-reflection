<?php

namespace TenantCloud\BetterReflection\Relocated;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
$image = \imagecreatetruecolor(1, 1);
$memoryHandle = \fopen('php://memory', 'w');
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \imagegd($image));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \imagegd($image, null));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \imagegd($image, 'php://memory'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', \imagegd($image, $memoryHandle));
