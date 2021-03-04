<?php

namespace TenantCloud\BetterReflection\Relocated\MethodWithInheritDoc;

interface FooInterface
{
    /**
     * @param string $str
     */
    public function doBar($str);
}
class Foo implements \TenantCloud\BetterReflection\Relocated\MethodWithInheritDoc\FooInterface
{
    /**
     * @param int $i
     */
    public function doFoo($i)
    {
    }
    /**
     * {@inheritDoc}
     */
    public function doBar($str)
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\MethodWithInheritDoc\Foo
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
class Baz extends \TenantCloud\BetterReflection\Relocated\MethodWithInheritDoc\Bar
{
    /**
     * {@inheritDoc}
     */
    public function doFoo($i)
    {
    }
}
function () {
    $baz = new \TenantCloud\BetterReflection\Relocated\MethodWithInheritDoc\Baz();
    $baz->doFoo(1);
    $baz->doFoo('1');
    $baz->doBar('1');
    $baz->doBar(1);
};
