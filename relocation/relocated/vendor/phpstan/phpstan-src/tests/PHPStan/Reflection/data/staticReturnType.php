<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\NativeStaticReturnType;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo() : \TenantCloud\BetterReflection\Relocated\static
    {
        return new static();
    }
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(NativeStaticReturnType\\Foo)', $this->doFoo());
    }
    /**
     * @return callable(): static
     */
    public function doBaz() : callable
    {
        $f = function () : static {
            return new static();
        };
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(NativeStaticReturnType\\Foo)', $f());
        return $f;
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\NativeStaticReturnType\Foo
{
}
function (\TenantCloud\BetterReflection\Relocated\NativeStaticReturnType\Foo $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\NativeStaticReturnType\\Foo', $foo->doFoo());
    $callable = $foo->doBaz();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\callable(): NativeStaticReturnType\\Foo', $callable);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\NativeStaticReturnType\\Foo', $callable());
};
function (\TenantCloud\BetterReflection\Relocated\NativeStaticReturnType\Bar $bar) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\NativeStaticReturnType\\Bar', $bar->doFoo());
    $callable = $bar->doBaz();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\callable(): NativeStaticReturnType\\Bar', $callable);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\NativeStaticReturnType\\Bar', $callable());
};
