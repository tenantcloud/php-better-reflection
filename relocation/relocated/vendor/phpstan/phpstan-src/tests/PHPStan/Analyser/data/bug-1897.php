<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug1897;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class ObjectA
{
}
class Example
{
    function foo(\TenantCloud\BetterReflection\Relocated\Bug1897\ObjectA $object = null) : void
    {
        $object = $object ?: new \TenantCloud\BetterReflection\Relocated\Bug1897\ObjectA();
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug1897\\ObjectA', $object);
    }
}
