<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\InvalidConstantNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\ConstantNodeChecker;
class CachingVisitor extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
{
    private string $fileName;
    /** @var array<string, array<FetchedNode<\PhpParser\Node\Stmt\ClassLike>>> */
    private array $classNodes;
    /** @var array<string, FetchedNode<\PhpParser\Node\Stmt\Function_>> */
    private array $functionNodes;
    /** @var array<int, FetchedNode<\PhpParser\Node\Stmt\Const_|\PhpParser\Node\Expr\FuncCall>> */
    private array $constantNodes;
    private ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $currentNamespaceNode = null;
    public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : ?int
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_) {
            $this->currentNamespaceNode = $node;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike) {
            if ($node->name !== null) {
                $fullClassName = $node->name->toString();
                if ($this->currentNamespaceNode !== null && $this->currentNamespaceNode->name !== null) {
                    $fullClassName = $this->currentNamespaceNode->name . '\\' . $fullClassName;
                }
                $this->classNodes[\strtolower($fullClassName)][] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNode($node, $this->currentNamespaceNode, $this->fileName);
            }
            return \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_) {
            $this->functionNodes[\strtolower($node->namespacedName->toString())] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNode($node, $this->currentNamespaceNode, $this->fileName);
            return \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Const_) {
            $this->constantNodes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNode($node, $this->currentNamespaceNode, $this->fileName);
            return \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
            try {
                \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\ConstantNodeChecker::assertValidDefineFunctionCall($node);
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                return null;
            }
            /** @var \PhpParser\Node\Scalar\String_ $nameNode */
            $nameNode = $node->args[0]->value;
            $constantName = $nameNode->value;
            if (\defined($constantName)) {
                $constantValue = \constant($constantName);
                $node->args[1]->value = \TenantCloud\BetterReflection\Relocated\PhpParser\BuilderHelpers::normalizeValue($constantValue);
            }
            $constantNode = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNode($node, $this->currentNamespaceNode, $this->fileName);
            $this->constantNodes[] = $constantNode;
            return \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
        return null;
    }
    /**
     * @param \PhpParser\Node $node
     * @return null
     */
    public function leaveNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_) {
            return null;
        }
        $this->currentNamespaceNode = null;
        return null;
    }
    /**
     * @return array<string, array<FetchedNode<\PhpParser\Node\Stmt\ClassLike>>>
     */
    public function getClassNodes() : array
    {
        return $this->classNodes;
    }
    /**
     * @return array<string, FetchedNode<\PhpParser\Node\Stmt\Function_>>
     */
    public function getFunctionNodes() : array
    {
        return $this->functionNodes;
    }
    /**
     * @return array<int, FetchedNode<\PhpParser\Node\Stmt\Const_|\PhpParser\Node\Expr\FuncCall>>
     */
    public function getConstantNodes() : array
    {
        return $this->constantNodes;
    }
    public function reset(string $fileName) : void
    {
        $this->classNodes = [];
        $this->functionNodes = [];
        $this->constantNodes = [];
        $this->fileName = $fileName;
    }
}
