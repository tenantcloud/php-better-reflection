<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\AnalyseTraits;

trait FooTrait
{
    public function doTraitFoo() : void
    {
        $this->doFoo();
    }
    public function conflictingMethodWithDifferentArgumentNames(string $string) : void
    {
        $r = \strpos($string, 'foo');
    }
}
