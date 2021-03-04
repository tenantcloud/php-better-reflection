<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2164;

class A
{
    /**
     * @param static|string $arg
     * @return void
     */
    public static function staticTest($arg)
    {
    }
}
class B extends \TenantCloud\BetterReflection\Relocated\Bug2164\A
{
    /**
     * @param B|string $arg
     * @return void
     */
    public function test($arg)
    {
        \TenantCloud\BetterReflection\Relocated\Bug2164\B::staticTest($arg);
    }
}
