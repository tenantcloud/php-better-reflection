<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocFromInterface2;

interface FooInterface extends \TenantCloud\BetterReflection\Relocated\InheritDocFromInterface2\BarInterface
{
}
interface BarInterface
{
    /**
     * @param int $int
     */
    public function doBar($int);
}
