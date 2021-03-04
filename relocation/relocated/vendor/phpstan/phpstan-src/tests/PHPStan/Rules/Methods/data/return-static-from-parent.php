<?php

namespace TenantCloud\BetterReflection\Relocated\ReturnStaticFromParent;

class Foo
{
    /**
     * @return static
     */
    public function doFoo() : self
    {
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\ReturnStaticFromParent\Foo
{
}
class Baz extends \TenantCloud\BetterReflection\Relocated\ReturnStaticFromParent\Bar
{
    public function doBaz() : self
    {
        $baz = $this->doFoo();
        return $baz;
    }
}
