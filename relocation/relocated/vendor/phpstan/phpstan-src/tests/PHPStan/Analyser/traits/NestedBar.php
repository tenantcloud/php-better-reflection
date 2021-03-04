<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\AnalyseTraits;

class NestedBar
{
    use NestedFooTrait;
    public function doBar() : void
    {
    }
}
