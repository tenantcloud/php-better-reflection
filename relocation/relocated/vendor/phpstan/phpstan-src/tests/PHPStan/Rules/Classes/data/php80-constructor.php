<?php

namespace TenantCloud\BetterReflection\Relocated;

class OldStyleConstructorOnPhp8
{
    public function OldStyleConstructorOnPhp8(int $i)
    {
    }
    public static function create() : self
    {
        return new self(1);
    }
}
function () {
    new \TenantCloud\BetterReflection\Relocated\OldStyleConstructorOnPhp8();
    new \TenantCloud\BetterReflection\Relocated\OldStyleConstructorOnPhp8(1);
};
