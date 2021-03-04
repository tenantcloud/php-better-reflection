<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\TraitErrors;

trait TraitWithAbstractMethod
{
    public abstract function getTitle() : string;
}
