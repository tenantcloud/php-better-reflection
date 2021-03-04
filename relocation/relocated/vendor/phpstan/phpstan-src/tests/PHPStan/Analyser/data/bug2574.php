<?php

namespace TenantCloud\BetterReflection\Relocated\Analyser\Bug2574;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
abstract class Model
{
    /** @return static */
    public function newInstance()
    {
        return new static();
    }
}
class Model1 extends \TenantCloud\BetterReflection\Relocated\Analyser\Bug2574\Model
{
}
/**
 * @template T of Model
 * @param T $m
 * @return T
 */
function foo(\TenantCloud\BetterReflection\Relocated\Analyser\Bug2574\Model $m) : \TenantCloud\BetterReflection\Relocated\Analyser\Bug2574\Model
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of Analyser\\Bug2574\\Model (function Analyser\\Bug2574\\foo(), argument)', $m);
    $instance = $m->newInstance();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of Analyser\\Bug2574\\Model (function Analyser\\Bug2574\\foo(), argument)', $m);
    return $instance;
}
function test() : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Analyser\\Bug2574\\Model1', foo(new \TenantCloud\BetterReflection\Relocated\Analyser\Bug2574\Model1()));
}
