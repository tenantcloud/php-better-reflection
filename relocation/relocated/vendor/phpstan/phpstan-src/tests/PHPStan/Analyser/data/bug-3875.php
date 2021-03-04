<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3875;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function foo() : void
{
    $queue = ['foo'];
    $list = [];
    do {
        $current = \array_pop($queue);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'foo\'', $current);
        if ($current === null) {
            break;
        }
        $list[] = $current;
    } while ($queue);
}
