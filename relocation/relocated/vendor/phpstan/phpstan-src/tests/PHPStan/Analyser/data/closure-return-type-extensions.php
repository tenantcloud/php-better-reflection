<?php

namespace TenantCloud\BetterReflection\Relocated\ClosureReturnTypeExtensionsNamespace;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
$predicate = function (object $thing) : bool {
    return \true;
};
$closure = \Closure::fromCallable($predicate);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Closure(object): true', $closure);
$newThis = new class
{
};
$boundClosure = $closure->bindTo($newThis);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Closure(object): true', $boundClosure);
$staticallyBoundClosure = \Closure::bind($closure, $newThis);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Closure(object): true', $staticallyBoundClosure);
$returnType = $closure->call($newThis, new class
{
});
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('true', $returnType);
