<?php

namespace TenantCloud\BetterReflection\Relocated\ReturnTypes;

class FooPhp70 extends \TenantCloud\BetterReflection\Relocated\ReturnTypes\FooParent implements \TenantCloud\BetterReflection\Relocated\ReturnTypes\FooInterface
{
    public function returnInteger() : int
    {
        return;
    }
}
