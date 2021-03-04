<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\AnalyseTraits;

trait NestedFooTrait
{
    use FooTrait;
    public function doNestedTraitFoo() : void
    {
        $this->doNestedFoo();
    }
}
