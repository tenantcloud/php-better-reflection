<?php

namespace TenantCloud\BetterReflection\Relocated\ParameterContravariance;

class Foo
{
    public function doFoo(\Exception $e)
    {
    }
    public function doBar(\InvalidArgumentException $e)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\ParameterContravariance\Foo
{
    public function doFoo(?\Exception $e)
    {
    }
    public function doBar(\Exception $e)
    {
    }
}
class Baz extends \TenantCloud\BetterReflection\Relocated\ParameterContravariance\Foo
{
    public function doBar(?\Exception $e)
    {
    }
}
class Lorem extends \TenantCloud\BetterReflection\Relocated\ParameterContravariance\Foo
{
    public function doFoo(\InvalidArgumentException $e)
    {
    }
}
class Ipsum extends \TenantCloud\BetterReflection\Relocated\ParameterContravariance\Foo
{
    public function doFoo(?\InvalidArgumentException $e)
    {
    }
}
