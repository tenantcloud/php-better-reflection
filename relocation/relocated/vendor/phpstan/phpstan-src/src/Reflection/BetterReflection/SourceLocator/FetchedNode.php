<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

/**
 * @template-covariant T of \PhpParser\Node
 */
class FetchedNode
{
    /** @var T */
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node $node;
    private ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace;
    private string $fileName;
    /**
     * @param T $node
     * @param \PhpParser\Node\Stmt\Namespace_|null $namespace
     * @param string $fileName
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace, string $fileName)
    {
        $this->node = $node;
        $this->namespace = $namespace;
        $this->fileName = $fileName;
    }
    /**
     * @return T
     */
    public function getNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node
    {
        return $this->node;
    }
    public function getNamespace() : ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_
    {
        return $this->namespace;
    }
    public function getFileName() : string
    {
        return $this->fileName;
    }
}
