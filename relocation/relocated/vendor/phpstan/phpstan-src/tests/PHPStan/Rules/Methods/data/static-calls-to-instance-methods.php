<?php

namespace TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods;

class Foo
{
    public static function doStaticFoo()
    {
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::doFoo();
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Bar::doBar();
        // not guaranteed, works only in instance of Bar
    }
    protected function doProtectedFoo()
    {
    }
    private function doPrivateFoo()
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo
{
    public static function doStaticBar()
    {
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doBar()
    {
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::doFoo();
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::dofoo();
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::doFoo(1);
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::doProtectedFoo();
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Foo::doPrivateFoo();
        \TenantCloud\BetterReflection\Relocated\StaticCallsToInstanceMethods\Bar::doBar();
        static::doFoo();
        static::doFoo(1);
    }
}
