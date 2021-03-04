<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\x;

class boo
{
}
namespace TenantCloud\BetterReflection\Relocated\y;

use TenantCloud\BetterReflection\Relocated\x\boo;
use TenantCloud\BetterReflection\Relocated\x\baz;
class x
{
    /** @var \x\boo */
    private $boo;
    /** @var \x\baz */
    private $baz;
    public function __construct(\TenantCloud\BetterReflection\Relocated\x\boo $boo, \TenantCloud\BetterReflection\Relocated\x\baz $baz)
    {
        $this->boo = $boo;
        $this->baz = $baz;
    }
}
