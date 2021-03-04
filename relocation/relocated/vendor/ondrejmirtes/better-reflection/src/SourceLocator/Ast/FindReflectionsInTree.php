<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast;

use Closure;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\InvalidConstantNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\ConstantNodeChecker;
use function assert;
use function count;
/**
 * @internal
 */
final class FindReflectionsInTree
{
    /** @var AstConversionStrategy */
    private $astConversionStrategy;
    /** @var FunctionReflector */
    private $functionReflector;
    /** @var Closure(): FunctionReflector */
    private $functionReflectorGetter;
    /**
     * @param Closure(): FunctionReflector $functionReflectorGetter
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy $astConversionStrategy, \Closure $functionReflectorGetter)
    {
        $this->astConversionStrategy = $astConversionStrategy;
        $this->functionReflectorGetter = $functionReflectorGetter;
    }
    /**
     * Find all reflections of a given type in an Abstract Syntax Tree
     *
     * @param Node[] $ast
     *
     * @return Reflection[]
     */
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, array $ast, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource) : array
    {
        $nodeVisitor = new class($reflector, $identifierType, $locatedSource, $this->astConversionStrategy, $this->functionReflectorGetter->__invoke()) extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
        {
            /** @var Reflection[] */
            private $reflections = [];
            /** @var Reflector */
            private $reflector;
            /** @var IdentifierType */
            private $identifierType;
            /** @var LocatedSource */
            private $locatedSource;
            /** @var AstConversionStrategy */
            private $astConversionStrategy;
            /** @var Namespace_|null */
            private $currentNamespace;
            /** @var FunctionReflector */
            private $functionReflector;
            public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\AstConversionStrategy $astConversionStrategy, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector $functionReflector)
            {
                $this->reflector = $reflector;
                $this->identifierType = $identifierType;
                $this->locatedSource = $locatedSource;
                $this->astConversionStrategy = $astConversionStrategy;
                $this->functionReflector = $functionReflector;
            }
            /**
             * {@inheritDoc}
             */
            public function enterNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
            {
                if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_) {
                    $this->currentNamespace = $node;
                    return null;
                }
                if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike) {
                    $classNamespace = $node->name === null ? null : $this->currentNamespace;
                    $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $classNamespace);
                    if ($this->identifierType->isMatchingReflector($reflection)) {
                        $this->reflections[] = $reflection;
                    }
                    return null;
                }
                if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassConst) {
                    return null;
                }
                if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Const_) {
                    for ($i = 0; $i < \count($node->consts); $i++) {
                        $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $this->currentNamespace, $i);
                        if (!$this->identifierType->isMatchingReflector($reflection)) {
                            continue;
                        }
                        $this->reflections[] = $reflection;
                    }
                    return null;
                }
                if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
                    try {
                        \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\ConstantNodeChecker::assertValidDefineFunctionCall($node);
                    } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                        return null;
                    }
                    if ($node->name->hasAttribute('namespacedName')) {
                        $namespacedName = $node->name->getAttribute('namespacedName');
                        \assert($namespacedName instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name);
                        if (\count($namespacedName->parts) > 1) {
                            try {
                                $this->functionReflector->reflect($namespacedName->toString());
                                return null;
                            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                                // Global define()
                            }
                        }
                    }
                    $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $this->currentNamespace);
                    if ($this->identifierType->isMatchingReflector($reflection)) {
                        $this->reflections[] = $reflection;
                    }
                    return null;
                }
                if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_) {
                    return null;
                }
                $reflection = $this->astConversionStrategy->__invoke($this->reflector, $node, $this->locatedSource, $this->currentNamespace);
                if (!$this->identifierType->isMatchingReflector($reflection)) {
                    return null;
                }
                $this->reflections[] = $reflection;
                return null;
            }
            /**
             * {@inheritDoc}
             */
            public function leaveNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node)
            {
                if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_) {
                    return null;
                }
                $this->currentNamespace = null;
                return null;
            }
            /**
             * @return Reflection[]
             */
            public function getReflections() : array
            {
                return $this->reflections;
            }
        };
        $nodeTraverser = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor(new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitor\NameResolver());
        $nodeTraverser->addVisitor($nodeVisitor);
        $nodeTraverser->traverse($ast);
        return $nodeVisitor->getReflections();
    }
}
