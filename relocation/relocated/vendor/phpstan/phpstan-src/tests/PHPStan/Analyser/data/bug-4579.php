<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4579;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function (string $class) : void {
    $foo = new $class();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~string', $foo);
    if (\method_exists($foo, 'doFoo')) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object&hasMethod(doFoo)', $foo);
    }
};
function () : void {
    $s = \stdClass::class;
    if (\rand(0, 1)) {
        $s = \Exception::class;
    }
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Exception|stdClass', new $s());
};
