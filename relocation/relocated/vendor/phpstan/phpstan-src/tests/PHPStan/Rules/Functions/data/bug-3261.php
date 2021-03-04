<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\Bug3261;

class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\Bug3261\A
{
}
function () : void {
    /** @var A[] $a */
    $a = [];
    \array_filter($a, fn(\TenantCloud\BetterReflection\Relocated\Bug3261\A $a) => $a instanceof \TenantCloud\BetterReflection\Relocated\Bug3261\B);
};
