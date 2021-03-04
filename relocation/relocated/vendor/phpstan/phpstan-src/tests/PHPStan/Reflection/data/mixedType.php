<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NativeMixedType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public mixed $fooProp;
    public function doFoo(mixed $foo) : mixed
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $this->fooProp);
    }
}
class Bar
{
}
function doFoo(mixed $foo) : mixed
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
}
function (\TenantCloud\BetterReflection\Relocated\NativeMixedType\Foo $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo->fooProp);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo->doFoo(1));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', doFoo(1));
};
function () : void {
    $f = function (mixed $foo) : mixed {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
    };
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('void', $f(1));
};
