<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\TestStringables;

class Dolor
{
    public function doFoo(string $s) : void
    {
    }
    public function doBar() : void
    {
        $this->doFoo(new \TenantCloud\BetterReflection\Relocated\TestStringables\Bar());
    }
}
