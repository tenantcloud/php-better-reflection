<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

class Granularity
{
    /**
     * @return mixed[]
     */
    protected static function provideInstances() : array
    {
        $myclass = new class extends \TenantCloud\BetterReflection\Relocated\Granularity
        {
        };
        return [];
    }
}
