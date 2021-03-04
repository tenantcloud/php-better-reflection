<?php

namespace TenantCloud\BetterReflection\Relocated;

$foo = 'foo';
/** @var int $foo */
$bar = $foo + 1;
function () : void {
    $foo = 'foo';
    /** @var int $foo */
    $bar = $foo + 1;
};
