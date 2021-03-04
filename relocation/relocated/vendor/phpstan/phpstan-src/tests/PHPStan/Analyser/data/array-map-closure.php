<?php

namespace TenantCloud\BetterReflection\Relocated\ArrayMapClosure;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class A
{
}
class B extends \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\A
{
}
class C extends \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\A
{
}
function () : void {
    \array_map(function ($item) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B::class . '|' . \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C::class, $item);
    }, [new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B(), new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C()]);
    \array_map(function (\TenantCloud\BetterReflection\Relocated\ArrayMapClosure\A $item) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B::class . '|' . \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C::class, $item);
    }, [new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B(), new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C()]);
};
function () : void {
    \array_filter([new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B(), new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C()], function ($item) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B::class . '|' . \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C::class, $item);
    });
    \array_filter([new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B(), new \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C()], function (\TenantCloud\BetterReflection\Relocated\ArrayMapClosure\A $item) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\ArrayMapClosure\B::class . '|' . \TenantCloud\BetterReflection\Relocated\ArrayMapClosure\C::class, $item);
    });
};
