<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

class InFunctionNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_ $originalNode;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_ $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_
    {
        return $this->originalNode;
    }
    public function getType() : string
    {
        return 'PHPStan_Stmt_InFunctionNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
