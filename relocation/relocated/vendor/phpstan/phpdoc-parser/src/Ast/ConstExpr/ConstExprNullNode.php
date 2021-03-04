<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr;

class ConstExprNullNode implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    public function __toString() : string
    {
        return 'null';
    }
}
