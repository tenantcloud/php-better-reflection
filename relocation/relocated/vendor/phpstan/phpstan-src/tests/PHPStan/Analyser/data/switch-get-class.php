<?php

namespace TenantCloud\BetterReflection\Relocated\SwitchGetClass;

class Foo
{
    public function doFoo()
    {
        $lorem = doFoo();
        switch (\get_class($lorem)) {
            case \TenantCloud\BetterReflection\Relocated\SwitchGetClass\Ipsum::class:
                break;
            case \TenantCloud\BetterReflection\Relocated\SwitchGetClass\Lorem::class:
                'normalName';
                break;
            case self::class:
                'selfReferentialName';
                break;
        }
    }
}
