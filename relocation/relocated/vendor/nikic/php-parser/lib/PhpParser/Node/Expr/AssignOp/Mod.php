<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp;
class Mod extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}
