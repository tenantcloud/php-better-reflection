<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\TraitErrors;

class ClassImplementingTraitWithAbstractMethod
{
    use TraitWithAbstractMethod;
    public function getTitle() : string
    {
        return 'foo';
    }
}
