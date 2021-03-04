<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor;

use function array_pop;
use function count;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
/**
 * Visitor that connects a child node to its parent node.
 *
 * On the child node, the parent node can be accessed through
 * <code>$node->getAttribute('parent')</code>.
 */
final class ParentConnectingVisitor extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
{
    /**
     * @var Node[]
     */
    private $stack = [];
    public function beforeTraverse(array $nodes)
    {
        $this->stack = [];
    }
    public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        if (!empty($this->stack)) {
            $node->setAttribute('parent', $this->stack[\count($this->stack) - 1]);
        }
        $this->stack[] = $node;
    }
    public function leaveNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        \array_pop($this->stack);
    }
}
