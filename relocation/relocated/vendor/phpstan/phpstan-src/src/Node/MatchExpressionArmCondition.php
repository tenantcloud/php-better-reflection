<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class MatchExpressionArmCondition
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $condition;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope;
    private int $line;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $condition, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, int $line)
    {
        $this->condition = $condition;
        $this->scope = $scope;
        $this->line = $line;
    }
    public function getCondition() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr
    {
        return $this->condition;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getLine() : int
    {
        return $this->line;
    }
}
