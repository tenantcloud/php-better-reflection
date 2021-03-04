<?php

namespace TenantCloud\BetterReflection\Relocated\VariadicParameterAlwaysOptional;

class Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar() : void
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\VariadicParameterAlwaysOptional\Foo
{
    public function doFoo(string ...$test) : void
    {
    }
    public function doBar(...$test) : void
    {
    }
}
