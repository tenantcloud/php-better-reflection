<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst;
class Line extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__LINE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Line';
    }
}
