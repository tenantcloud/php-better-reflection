<?php

namespace TenantCloud\BetterReflection\Relocated\LessParametersVariadics;

class Foo
{
    public function doFoo(int $many, string $parameters, string $here)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\LessParametersVariadics\Foo
{
    public function doFoo(...$everything)
    {
    }
}
class Baz extends \TenantCloud\BetterReflection\Relocated\LessParametersVariadics\Foo
{
    public function doFoo(int ...$everything)
    {
    }
}
class Lorem extends \TenantCloud\BetterReflection\Relocated\LessParametersVariadics\Foo
{
    public function doFoo(int $many, string ...$everything)
    {
    }
}
