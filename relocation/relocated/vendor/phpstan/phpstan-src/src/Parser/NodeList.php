<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Parser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
class NodeList
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node $node;
    private ?\TenantCloud\BetterReflection\Relocated\self $next;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, ?self $next = null)
    {
        $this->node = $node;
        $this->next = $next;
    }
    public function append(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : self
    {
        $current = $this;
        while ($current->next !== null) {
            $current = $current->next;
        }
        $new = new self($node);
        $current->next = $new;
        return $new;
    }
    public function getNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return $this->node;
    }
    public function getNext() : ?self
    {
        return $this->next;
    }
}
