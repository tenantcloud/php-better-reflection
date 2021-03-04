<?php

namespace TenantCloud\BetterReflection\Relocated;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>|false', \preg_split('/-/', '1-2-3'));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>|false', \preg_split('/-/', '1-2-3', -1, \PREG_SPLIT_NO_EMPTY));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, array(string, int)>|false', \preg_split('/-/', '1-2-3', -1, \PREG_SPLIT_OFFSET_CAPTURE));
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, array(string, int)>|false', \preg_split('/-/', '1-2-3', -1, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_OFFSET_CAPTURE));
