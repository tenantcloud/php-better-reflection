<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\TraitErrors;

trait MyTrait
{
    public function test() : void
    {
        echo $undefined;
        $this->undefined($undefined);
    }
}
class MyClass
{
    use MyTrait;
}
