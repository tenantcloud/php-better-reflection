<?php

namespace TenantCloud\BetterReflection\Relocated\AbstractMethod;

abstract class Foo
{
    public abstract function doFoo() : void;
}
class Bar
{
    public abstract function doBar() : void;
}
interface Baz
{
    public abstract function doBar() : void;
}
