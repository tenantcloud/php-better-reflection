<?php

namespace TenantCloud\BetterReflection\Relocated\MissingMethodImpl;

interface Foo
{
    public function doFoo();
}
abstract class Bar implements \TenantCloud\BetterReflection\Relocated\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
class Baz implements \TenantCloud\BetterReflection\Relocated\MissingMethodImpl\Foo
{
    public function doBar()
    {
    }
    public abstract function doBaz();
}
interface Lorem extends \TenantCloud\BetterReflection\Relocated\MissingMethodImpl\Foo
{
}
new class implements \TenantCloud\BetterReflection\Relocated\MissingMethodImpl\Foo
{
};
