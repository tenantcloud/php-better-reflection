<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalOr;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class BooleanOrNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    /** @var BooleanOr|LogicalOr */
    private $originalNode;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $rightScope;
    /**
     * @param BooleanOr|LogicalOr $originalNode
     * @param Scope $rightScope
     */
    public function __construct($originalNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $rightScope)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
        $this->rightScope = $rightScope;
    }
    /**
     * @return BooleanOr|LogicalOr
     */
    public function getOriginalNode()
    {
        return $this->originalNode;
    }
    public function getRightScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->rightScope;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_BooleanOrNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
