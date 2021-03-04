<?php

namespace TenantCloud\BetterReflection\Relocated\MethodWithInheritDocWithoutCurlyBraces;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \TenantCloud\BetterReflection\Relocated\MethodWithInheritDocWithoutCurlyBraces\FooInterface
{
    /**
     * @param int $i
     */
    public function doFoo($i)
    {
    }
    /**
     * @inheritDoc
     */
    public function doBar($str)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\MethodWithInheritDocWithoutCurlyBraces\Foo
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \TenantCloud\BetterReflection\Relocated\MethodWithInheritDocWithoutCurlyBraces\Bar
{
    /**
     * @inheritDoc
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \TenantCloud\BetterReflection\Relocated\MethodWithInheritDocWithoutCurlyBraces\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
