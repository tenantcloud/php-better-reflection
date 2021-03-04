<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
class InArrowFunctionNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction $originalNode;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction
    {
        return $this->originalNode;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_InArrowFunctionNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
