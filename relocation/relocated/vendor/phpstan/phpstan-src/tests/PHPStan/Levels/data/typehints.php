<?php

namespace TenantCloud\BetterReflection\Relocated\Levels\Typehints;

class Foo
{
    public function doFoo(\TenantCloud\BetterReflection\Relocated\Levels\Typehints\Lorem $lorem) : \TenantCloud\BetterReflection\Relocated\Levels\Typehints\Ipsum
    {
        return new \TenantCloud\BetterReflection\Relocated\Levels\Typehints\Ipsum();
    }
    /**
     * @param Lorem $lorem
     * @return Ipsum
     */
    public function doBar($lorem)
    {
        return new \TenantCloud\BetterReflection\Relocated\Levels\Typehints\Ipsum();
    }
}
