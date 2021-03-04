<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class MatchExpressionNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $condition;
    /** @var MatchExpressionArm[] */
    private array $arms;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $endScope;
    /**
     * @param Expr $condition
     * @param MatchExpressionArm[] $arms
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $condition, array $arms, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Match_ $originalNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $endScope)
    {
        parent::__construct($originalNode->getAttributes());
        $this->condition = $condition;
        $this->arms = $arms;
        $this->endScope = $endScope;
    }
    public function getCondition() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr
    {
        return $this->condition;
    }
    /**
     * @return MatchExpressionArm[]
     */
    public function getArms() : array
    {
        return $this->arms;
    }
    public function getEndScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->endScope;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_MatchExpression';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
