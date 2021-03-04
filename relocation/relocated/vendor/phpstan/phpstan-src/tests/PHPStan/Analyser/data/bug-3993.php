<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3993;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo($arguments)
    {
        if (!isset($arguments) || \count($arguments) === 0) {
            return;
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~null', $arguments);
        \array_shift($arguments);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed~null', $arguments);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int<0, max>', \count($arguments));
    }
}
