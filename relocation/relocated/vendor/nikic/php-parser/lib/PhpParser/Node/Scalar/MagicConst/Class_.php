<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst;
class Class_ extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__CLASS__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Class';
    }
}
