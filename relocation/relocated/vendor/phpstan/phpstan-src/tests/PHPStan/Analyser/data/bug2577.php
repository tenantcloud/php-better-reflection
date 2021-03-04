<?php

namespace TenantCloud\BetterReflection\Relocated\Analyser\Bug2577;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class A
{
}
class A1 extends \TenantCloud\BetterReflection\Relocated\Analyser\Bug2577\A
{
}
class A2 extends \TenantCloud\BetterReflection\Relocated\Analyser\Bug2577\A
{
}
/**
 * @template T of A
 *
 * @param \Closure():T $t1
 * @param T $t2
 * @return T
 */
function echoOneOrOther(\Closure $t1, \TenantCloud\BetterReflection\Relocated\Analyser\Bug2577\A $t2)
{
    echo \get_class($t1());
    echo \get_class($t2);
    throw new \Exception();
}
function test() : void
{
    $result = echoOneOrOther(function () : A1 {
        return new \TenantCloud\BetterReflection\Relocated\Analyser\Bug2577\A1();
    }, new \TenantCloud\BetterReflection\Relocated\Analyser\Bug2577\A2());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Analyser\\Bug2577\\A1|Analyser\\Bug2577\\A2', $result);
}
