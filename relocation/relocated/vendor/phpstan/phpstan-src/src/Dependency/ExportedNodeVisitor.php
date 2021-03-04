<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Dependency;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
class ExportedNodeVisitor extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver;
    private ?string $fileName = null;
    /** @var ExportedNode[] */
    private array $currentNodes = [];
    /**
     * ExportedNodeVisitor constructor.
     *
     * @param ExportedNodeResolver $exportedNodeResolver
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver)
    {
        $this->exportedNodeResolver = $exportedNodeResolver;
    }
    public function reset(string $fileName) : void
    {
        $this->fileName = $fileName;
        $this->currentNodes = [];
    }
    /**
     * @return ExportedNode[]
     */
    public function getExportedNodes() : array
    {
        return $this->currentNodes;
    }
    public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : ?int
    {
        if ($this->fileName === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $exportedNode = $this->exportedNodeResolver->resolve($this->fileName, $node);
        if ($exportedNode !== null) {
            $this->currentNodes[] = $exportedNode;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_ || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Trait_) {
            return \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        return null;
    }
}
