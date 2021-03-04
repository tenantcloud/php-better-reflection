<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3336;

function (array $arr, string $str, $mixed) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', \mb_convert_encoding($arr));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', \mb_convert_encoding($str));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>|string|false', \mb_convert_encoding($mixed));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>|string|false', \mb_convert_encoding());
};
