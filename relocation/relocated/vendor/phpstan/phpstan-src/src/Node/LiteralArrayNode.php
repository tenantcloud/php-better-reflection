<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
class LiteralArrayNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    /** @var LiteralArrayItem[] */
    private array $itemNodes;
    /**
     * @param Array_ $originalNode
     * @param LiteralArrayItem[] $itemNodes
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_ $originalNode, array $itemNodes)
    {
        parent::__construct($originalNode->getAttributes());
        $this->itemNodes = $itemNodes;
    }
    /**
     * @return LiteralArrayItem[]
     */
    public function getItemNodes() : array
    {
        return $this->itemNodes;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_LiteralArray';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
