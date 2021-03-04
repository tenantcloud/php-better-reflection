<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\TraitErrors;

class TraitInEvalUse
{
    use \TraitInEval;
    public function doLorem() : void
    {
        $this->doFoo(1);
    }
}
