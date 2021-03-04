<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp;
class Plus extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '+';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Plus';
    }
}
