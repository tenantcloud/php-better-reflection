<?php

namespace TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromInterface2;

interface FooInterface extends \TenantCloud\BetterReflection\Relocated\InheritDocWithoutCurlyBracesFromInterface2\BarInterface
{
}
interface BarInterface
{
    /**
     * @param int $int
     */
    public function doBar($int);
}
