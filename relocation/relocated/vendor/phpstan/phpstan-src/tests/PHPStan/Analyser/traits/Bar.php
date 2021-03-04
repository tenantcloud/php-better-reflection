<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\AnalyseTraits;

class Bar
{
    use FooTrait;
    public function doBar() : void
    {
    }
}
