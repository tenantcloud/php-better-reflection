<?php

namespace TenantCloud\BetterReflection\Relocated;

function () : void {
    $scalar = 3;
    echo $scalar ?? 4;
    echo $doesNotExist ?? 0;
};
function (?string $a) : void {
    if (!\is_string($a)) {
        echo $a ?? 'foo';
    }
};
