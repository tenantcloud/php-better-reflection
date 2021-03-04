<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\UnpackOperator;

class Foo
{
    /**
     * @param string[] $strings
     */
    public function doFoo(array $strings)
    {
        $constantArray = ['foo', 'bar', 'baz'];
        \sprintf('%s', ...$strings);
        \sprintf('%s', ...$constantArray);
        \sprintf('%s', $strings);
        \sprintf('%s', $constantArray);
        \sprintf(...$strings);
        \sprintf(...$constantArray);
        \sprintf('%s', new \TenantCloud\BetterReflection\Relocated\UnpackOperator\Foo());
        \sprintf('%s', new \TenantCloud\BetterReflection\Relocated\UnpackOperator\Bar());
        \printf('%s', new \TenantCloud\BetterReflection\Relocated\UnpackOperator\Foo());
        \printf('%s', new \TenantCloud\BetterReflection\Relocated\UnpackOperator\Bar());
    }
}
class Bar
{
    public function __toString()
    {
    }
}
