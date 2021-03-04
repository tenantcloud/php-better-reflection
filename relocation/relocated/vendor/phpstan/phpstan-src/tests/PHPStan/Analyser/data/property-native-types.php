<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\PropertyNativeTypes;

class Foo
{
    private string $stringProp;
    private \TenantCloud\BetterReflection\Relocated\self $selfProp;
    /** @var int[] */
    private array $integersProp;
    public function doFoo()
    {
        die;
    }
}
