<?php

namespace TenantCloud\BetterReflection\Relocated\MixinMethods;

class Foo
{
    public function doFoo()
    {
    }
}
/**
 * @mixin Foo
 */
class Bar
{
    public function doBar()
    {
    }
}
function (\TenantCloud\BetterReflection\Relocated\MixinMethods\Bar $bar) : void {
    $bar->doFoo();
    $bar->doFoo(1);
};
class Baz extends \TenantCloud\BetterReflection\Relocated\MixinMethods\Bar
{
}
function (\TenantCloud\BetterReflection\Relocated\MixinMethods\Baz $baz) : void {
    $baz->doFoo();
    $baz->doFoo(1);
};
/**
 * @template T
 * @mixin T
 */
class GenericFoo
{
}
class Test
{
    /**
     * @param GenericFoo<\Exception> $foo
     */
    public function doFoo(\TenantCloud\BetterReflection\Relocated\MixinMethods\GenericFoo $foo) : void
    {
        echo $foo->getMessage();
        echo $foo->getMessage(1);
        echo $foo->getMessagee();
    }
}
