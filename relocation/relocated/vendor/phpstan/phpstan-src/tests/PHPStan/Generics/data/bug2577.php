<?php

namespace TenantCloud\BetterReflection\Relocated\Generics\Bug2577;

class A
{
}
class A1 extends \TenantCloud\BetterReflection\Relocated\Generics\Bug2577\A
{
}
class A2 extends \TenantCloud\BetterReflection\Relocated\Generics\Bug2577\A
{
}
/**
 * @template T of A
 *
 * @param \Closure():T $t1
 * @param T $t2
 */
function echoOneOrOther(\Closure $t1, \TenantCloud\BetterReflection\Relocated\Generics\Bug2577\A $t2) : void
{
    echo \get_class($t1());
    echo \get_class($t2);
}
function test() : void
{
    echoOneOrOther(function () : A1 {
        return new \TenantCloud\BetterReflection\Relocated\Generics\Bug2577\A1();
    }, new \TenantCloud\BetterReflection\Relocated\Generics\Bug2577\A2());
}
