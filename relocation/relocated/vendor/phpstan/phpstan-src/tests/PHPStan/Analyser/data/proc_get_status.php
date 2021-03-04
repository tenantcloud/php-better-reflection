<?php

namespace TenantCloud\BetterReflection\Relocated\ProcGetStatusBug;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
use function proc_get_status;
function ($r) : void {
    $status = \proc_get_status($r);
    if ($status === \false) {
        return;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'command\' => string, \'pid\' => int, \'running\' => bool, \'signaled\' => bool, \'stopped\' => bool, \'exitcode\' => int, \'termsig\' => int, \'stopsig\' => int)', $status);
};
