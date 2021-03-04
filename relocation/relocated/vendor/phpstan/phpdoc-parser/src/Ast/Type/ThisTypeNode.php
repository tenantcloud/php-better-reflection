<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type;

class ThisTypeNode implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    public function __toString() : string
    {
        return '$this';
    }
}
