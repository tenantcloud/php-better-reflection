<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3997Type;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (\Countable $c) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $c->count());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($c));
};
function (\ArrayIterator $i) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', $i->count());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($i));
};
