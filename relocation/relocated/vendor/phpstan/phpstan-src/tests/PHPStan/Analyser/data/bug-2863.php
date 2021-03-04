<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2863;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
$result = \json_decode('{"a":5}');
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \json_last_error());
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', \json_last_error_msg());
if (\json_last_error() !== \JSON_ERROR_NONE || \json_last_error_msg() !== 'No error') {
    throw new \TenantCloud\BetterReflection\Relocated\Bug2863\Exception(\json_last_error_msg());
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', \json_last_error());
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'No error'", \json_last_error_msg());
//
$result2 = \json_decode('');
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \json_last_error());
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', \json_last_error_msg());
if (\json_last_error() !== \JSON_ERROR_NONE || \json_last_error_msg() !== 'No error') {
    throw new \TenantCloud\BetterReflection\Relocated\Bug2863\Exception(\json_last_error_msg());
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', \json_last_error());
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'No error'", \json_last_error_msg());
//
$result3 = \json_encode([]);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', \json_last_error());
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', \json_last_error_msg());
if (\json_last_error() !== \JSON_ERROR_NONE || \json_last_error_msg() !== 'No error') {
    throw new \TenantCloud\BetterReflection\Relocated\Bug2863\Exception(\json_last_error_msg());
}
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('0', \json_last_error());
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType("'No error'", \json_last_error_msg());
