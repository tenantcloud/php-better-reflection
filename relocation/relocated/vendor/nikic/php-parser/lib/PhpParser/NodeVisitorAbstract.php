<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser;

/**
 * @codeCoverageIgnore
 */
class NodeVisitorAbstract implements \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor
{
    public function beforeTraverse(array $nodes)
    {
        return null;
    }
    public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        return null;
    }
    public function leaveNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        return null;
    }
    public function afterTraverse(array $nodes)
    {
        return null;
    }
}
