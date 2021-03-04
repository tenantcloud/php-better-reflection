<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3445;

class Foo
{
    public function doFoo(self $test) : void
    {
    }
    public function doBar($test = \TenantCloud\BetterReflection\Relocated\Bug3445\UnknownClass::BAR) : void
    {
    }
}
class Bar
{
    public function doFoo(\TenantCloud\BetterReflection\Relocated\Bug3445\Foo $foo)
    {
        $foo->doFoo(new \TenantCloud\BetterReflection\Relocated\Bug3445\Foo());
        $foo->doFoo($this);
        $foo->doBar(new \stdClass());
    }
}
