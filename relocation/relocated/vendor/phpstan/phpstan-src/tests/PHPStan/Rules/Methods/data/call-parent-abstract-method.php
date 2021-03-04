<?php

namespace TenantCloud\BetterReflection\Relocated\CallParentAbstractMethod;

interface Baz
{
    public function uninstall() : void;
}
abstract class Foo implements \TenantCloud\BetterReflection\Relocated\CallParentAbstractMethod\Baz
{
}
class Bar extends \TenantCloud\BetterReflection\Relocated\CallParentAbstractMethod\Foo
{
    public function uninstall() : void
    {
        parent::uninstall();
    }
}
abstract class Lorem
{
    public abstract function doFoo() : void;
}
class Ipsum extends \TenantCloud\BetterReflection\Relocated\CallParentAbstractMethod\Lorem
{
    public function doFoo() : void
    {
        parent::doFoo();
    }
}
abstract class Dolor extends \TenantCloud\BetterReflection\Relocated\CallParentAbstractMethod\Lorem
{
    public function doBar() : void
    {
        parent::doFoo();
    }
}
abstract class SitAmet
{
    static abstract function doFoo() : void;
}
function () : void {
    \TenantCloud\BetterReflection\Relocated\CallParentAbstractMethod\SitAmet::doFoo();
};
abstract class Consecteur
{
    public function doFoo()
    {
        static::doBar();
    }
    public abstract function doBar() : void;
}
