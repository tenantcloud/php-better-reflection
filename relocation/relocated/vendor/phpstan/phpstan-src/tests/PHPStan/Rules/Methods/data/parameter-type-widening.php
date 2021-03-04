<?php

namespace TenantCloud\BetterReflection\Relocated\ParameterTypeWidening;

class Foo
{
    public function doFoo(string $foo) : void
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\ParameterTypeWidening\Foo
{
    public function doFoo($foo) : void
    {
    }
}
