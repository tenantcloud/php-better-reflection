<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Visitor;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
class ReturnNodeVisitor extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
{
    /** @var Node\Stmt\Return_[] */
    private $returnNodes = [];
    public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : ?int
    {
        if ($this->isScopeChangingNode($node)) {
            return \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_) {
            $this->returnNodes[] = $node;
        }
        return null;
    }
    private function isScopeChangingNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : bool
    {
        return $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
    }
    /**
     * @return Node\Stmt\Return_[]
     */
    public function getReturnNodes() : array
    {
        return $this->returnNodes;
    }
}
