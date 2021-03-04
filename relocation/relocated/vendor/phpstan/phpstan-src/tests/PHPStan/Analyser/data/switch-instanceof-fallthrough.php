<?php

namespace TenantCloud\BetterReflection\Relocated\SwitchInstanceOfFallthrough;

class Foo
{
    /**
     * @param object $object
     */
    public function doFoo($object)
    {
        switch (\true) {
            case $object instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOfFallthrough\A:
            case $object instanceof \TenantCloud\BetterReflection\Relocated\SwitchInstanceOfFallthrough\B:
                die;
        }
    }
}
