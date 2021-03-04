<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst;
class Dir extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__DIR__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Dir';
    }
}
