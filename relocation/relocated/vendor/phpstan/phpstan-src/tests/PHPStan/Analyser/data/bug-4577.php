<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4577;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Test
{
    public function test(\ReflectionClass $refClass) : void
    {
        if ($refClass->isSubclassOf(\TenantCloud\BetterReflection\Relocated\Bug4577\Test::class)) {
            $instance = $refClass->newInstance();
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4577\Test::class, $instance);
        }
    }
}
