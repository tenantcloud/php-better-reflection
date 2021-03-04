<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class EnsuredNonNullabilityResultExpression
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expression;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $originalType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $originalNativeType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expression, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $originalType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $originalNativeType)
    {
        $this->expression = $expression;
        $this->originalType = $originalType;
        $this->originalNativeType = $originalNativeType;
    }
    public function getExpression() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr
    {
        return $this->expression;
    }
    public function getOriginalType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->originalType;
    }
    public function getOriginalNativeType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->originalNativeType;
    }
}
