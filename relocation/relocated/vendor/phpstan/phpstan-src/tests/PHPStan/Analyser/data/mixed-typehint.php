<?php

namespace TenantCloud\BetterReflection\Relocated\MixedTypehint;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(mixed $foo)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $this->doBar());
    }
    public function doBar() : mixed
    {
    }
}
function doFoo(mixed $foo)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
}
function (mixed $foo) {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $foo);
    $f = function () : mixed {
    };
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('void', $f());
    $f = function () use($foo) : mixed {
        return $foo;
    };
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', $f());
};
