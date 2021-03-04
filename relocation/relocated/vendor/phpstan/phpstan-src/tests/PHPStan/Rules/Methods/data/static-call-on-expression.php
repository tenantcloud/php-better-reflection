<?php

namespace TenantCloud\BetterReflection\Relocated\StaticCallOnExpression;

class Foo
{
    public static function doFoo() : self
    {
        return new static();
    }
}
function () {
    \TenantCloud\BetterReflection\Relocated\StaticCallOnExpression\Foo::doFoo()::doBar();
};
