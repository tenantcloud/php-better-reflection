<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class BooleanAndNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    /** @var BooleanAnd|LogicalAnd */
    private $originalNode;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $rightScope;
    /**
     * @param BooleanAnd|LogicalAnd $originalNode
     * @param Scope $rightScope
     */
    public function __construct($originalNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $rightScope)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
        $this->rightScope = $rightScope;
    }
    /**
     * @return BooleanAnd|LogicalAnd
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
        return 'PHPStan_Node_BooleanAndNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
