<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2740;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (\TenantCloud\BetterReflection\Relocated\Bug2740\Member $member) : void {
    foreach ($member as $i) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug2740\\Member', $i);
    }
};
