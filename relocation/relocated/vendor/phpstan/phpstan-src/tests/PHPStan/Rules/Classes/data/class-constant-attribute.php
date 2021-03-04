<?php

namespace TenantCloud\BetterReflection\Relocated\ClassConstantAttribute;

#[MyAttr(self::FOO), MyAttr(self::BAR)]
class Foo
{
    #[MyAttr(self::FOO), MyAttr(self::BAR)]
    private const FOO = 1;
    #[MyAttr(self::FOO), MyAttr(self::BAR)]
    private $fooProp;
    #[MyAttr(self::FOO), MyAttr(self::BAR)]
    public function doFoo(#[MyAttr(self::FOO), MyAttr(self::BAR)] $test) : void
    {
    }
}
#[MyAttr(\TenantCloud\BetterReflection\Relocated\ClassConstantAttribute\Foo::FOO), MyAttr(\TenantCloud\BetterReflection\Relocated\ClassConstantAttribute\Foo::BAR)]
function doFoo() : void
{
}
