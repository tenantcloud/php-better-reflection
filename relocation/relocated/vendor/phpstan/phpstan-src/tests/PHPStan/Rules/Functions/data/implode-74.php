<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Implode74;

function (string $a, string $b, array $array) : void {
    \implode($a, $array);
    \implode($array);
    \implode($array, $a);
    // disallowed
};
