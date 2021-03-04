<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type;

use Closure;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
use TenantCloud\BetterReflection\Relocated\PhpParser\Parser;
use ReflectionFunction as CoreFunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\EvaledClosureCannotBeLocated;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\TwoClosuresOnSameLine;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper;
use function array_filter;
use function array_values;
use function assert;
use function file_get_contents;
use function is_array;
use function strpos;
/**
 * @internal
 */
final class ClosureSourceLocator implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var CoreFunctionReflection */
    private $coreFunctionReflection;
    /** @var Parser */
    private $parser;
    public function __construct(\Closure $closure, \TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser)
    {
        $this->coreFunctionReflection = new \ReflectionFunction($closure);
        $this->parser = $parser;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        return $this->getReflectionFunction($reflector, $identifier->getType());
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifiersByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return \array_filter([$this->getReflectionFunction($reflector, $identifierType)]);
    }
    private function getReflectionFunction(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction
    {
        if (!$identifierType->isFunction()) {
            return null;
        }
        $fileName = $this->coreFunctionReflection->getFileName();
        if (\strpos($fileName, 'eval()\'d code') !== \false) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\EvaledClosureCannotBeLocated::create();
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        $fileName = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper::normalizeWindowsPath($fileName);
        $nodeVisitor = new class($fileName, $this->coreFunctionReflection->getStartLine()) extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
        {
            /** @var string */
            private $fileName;
            /** @var int */
            private $startLine;
            /** @var (Node|null)[][] */
            private $closureNodes = [];
            /** @var Namespace_|null */
            private $currentNamespace;
            public function __construct(string $fileName, int $startLine)
            {
                $this->fileName = $fileName;
                $this->startLine = $startLine;
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
                if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure) {
                    return null;
                }
                $this->closureNodes[] = [$node, $this->currentNamespace];
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
             * @return Node[]|null[]|null
             *
             * @throws TwoClosuresOnSameLine
             */
            public function getClosureNodes() : ?array
            {
                /** @var (Node|null)[][] $closureNodesDataOnSameLine */
                $closureNodesDataOnSameLine = \array_values(\array_filter($this->closureNodes, function (array $nodes) : bool {
                    return $nodes[0]->getLine() === $this->startLine;
                }));
                if (!$closureNodesDataOnSameLine) {
                    return null;
                }
                if (isset($closureNodesDataOnSameLine[1])) {
                    throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\TwoClosuresOnSameLine::create($this->fileName, $this->startLine);
                }
                return $closureNodesDataOnSameLine[0];
            }
        };
        $fileContents = \file_get_contents($fileName);
        $ast = $this->parser->parse($fileContents);
        $nodeTraverser = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($nodeVisitor);
        $nodeTraverser->traverse($ast);
        $closureNodes = $nodeVisitor->getClosureNodes();
        \assert(\is_array($closureNodes));
        \assert($closureNodes[1] instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ || $closureNodes[1] === null);
        $reflectionFunction = (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection())->__invoke($reflector, $closureNodes[0], new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource($fileContents, $fileName), $closureNodes[1]);
        \assert($reflectionFunction instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction || $reflectionFunction === null);
        return $reflectionFunction;
    }
}
