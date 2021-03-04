<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr;

class ConstExprTrueNode implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    public function __toString() : string
    {
        return 'true';
    }
}
