<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\NodeVisitor;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
class StatementOrderVisitor extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
{
    /** @var int[] */
    private array $orderStack = [];
    /** @var int[] */
    private array $expressionOrderStack = [];
    private int $depth = 0;
    private int $expressionDepth = 0;
    /**
     * @param Node[] $nodes $nodes
     * @return null
     */
    public function beforeTraverse(array $nodes)
    {
        $this->orderStack = [0];
        $this->depth = 0;
        return null;
    }
    /**
     * @param Node $node
     * @return null
     */
    public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        $order = $this->orderStack[\count($this->orderStack) - 1];
        $node->setAttribute('statementOrder', $order);
        $node->setAttribute('statementDepth', $this->depth);
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr && \count($this->expressionOrderStack) > 0) {
            $expressionOrder = $this->expressionOrderStack[\count($this->expressionOrderStack) - 1];
            $node->setAttribute('expressionOrder', $expressionOrder);
            $node->setAttribute('expressionDepth', $this->expressionDepth);
            $this->expressionOrderStack[\count($this->expressionOrderStack) - 1] = $expressionOrder + 1;
            $this->expressionOrderStack[] = 0;
            $this->expressionDepth++;
        }
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt) {
            return null;
        }
        $this->orderStack[\count($this->orderStack) - 1] = $order + 1;
        $this->orderStack[] = 0;
        $this->depth++;
        $this->expressionOrderStack = [0];
        $this->expressionDepth = 0;
        return null;
    }
    /**
     * @param Node $node
     * @return null
     */
    public function leaveNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            \array_pop($this->expressionOrderStack);
            $this->expressionDepth--;
        }
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt) {
            return null;
        }
        \array_pop($this->orderStack);
        $this->depth--;
        return null;
    }
}
