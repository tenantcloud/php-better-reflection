<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NativeUnionTypes;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public int|bool $fooProp;
    public function doFoo(int|bool $foo) : self|Bar
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|int', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|int', $this->fooProp);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('bool|int', $foo);
    }
}
class Bar
{
}
function doFoo(int|bool $foo) : Foo|Bar
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|int', $foo);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('bool|int', $foo);
}
function (\TenantCloud\BetterReflection\Relocated\NativeUnionTypes\Foo $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|int', $foo->fooProp);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $foo->doFoo(1));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', doFoo(1));
};
function () : void {
    $f = function (int|bool $foo) : Foo|Bar {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool|int', $foo);
    };
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\NativeUnionTypes\\Bar|NativeUnionTypes\\Foo', $f(1));
};
class Baz
{
    public function doFoo(array|false $foo) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array|false', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array|false', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array|false', $this->doBar());
    }
    public function doBar() : array|false
    {
    }
    /**
     * @param array<int, string> $foo
     */
    public function doBaz(array|false $foo) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>|false', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('array|false', $foo);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>|false', $this->doLorem());
    }
    /**
     * @return array<int, string>
     */
    public function doLorem() : array|false
    {
    }
    public function doIpsum(int|string|null $nullable) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string|null', $nullable);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertNativeType('int|string|null', $nullable);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string|null', $this->doDolor());
    }
    public function doDolor() : int|string|null
    {
    }
}
