<?php

namespace TenantCloud\BetterReflection\Relocated\AnonymousTraitClass;

trait TraitWithTypeSpecification
{
    /** @var string */
    private $string;
    public function doFoo() : void
    {
        if (!$this instanceof \TenantCloud\BetterReflection\Relocated\AnonymousTraitClass\FooInterface) {
            return;
        }
        $this->string = 'foo';
        $this->nonexistent = 'bar';
    }
}
