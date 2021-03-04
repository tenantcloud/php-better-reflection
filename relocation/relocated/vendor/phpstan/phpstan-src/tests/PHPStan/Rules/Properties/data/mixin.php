<?php

namespace TenantCloud\BetterReflection\Relocated\MixinProperties;

class Foo
{
    public $fooProp;
}
/**
 * @mixin Foo
 */
class Bar
{
}
function (\TenantCloud\BetterReflection\Relocated\MixinProperties\Bar $bar) : void {
    $bar->fooProp;
};
class Baz extends \TenantCloud\BetterReflection\Relocated\MixinProperties\Bar
{
}
function (\TenantCloud\BetterReflection\Relocated\MixinProperties\Baz $baz) : void {
    $baz->fooProp;
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
     * @param GenericFoo<\ReflectionClass> $foo
     */
    public function doFoo(\TenantCloud\BetterReflection\Relocated\MixinProperties\GenericFoo $foo) : void
    {
        echo $foo->name;
        echo $foo->namee;
    }
}
