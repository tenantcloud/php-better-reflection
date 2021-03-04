<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug3798;

/** @param callable(int ...$params) : void $c */
function acceptsVariadicCallable(callable $c) : void
{
    $c();
    $c(1);
    $c(1, 2, 3);
}
