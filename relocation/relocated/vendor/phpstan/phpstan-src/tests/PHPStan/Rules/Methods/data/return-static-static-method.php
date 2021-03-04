<?php

namespace TenantCloud\BetterReflection\Relocated\ReturnStaticStaticMethod;

class Foo
{
    /**
     * @return static
     */
    public static function doFoo() : self
    {
        return new static();
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\ReturnStaticStaticMethod\Foo
{
    public function doBar()
    {
        self::doFoo()::doFoo()::doBar();
        self::doFoo()::doFoo()::doBaz();
    }
}
