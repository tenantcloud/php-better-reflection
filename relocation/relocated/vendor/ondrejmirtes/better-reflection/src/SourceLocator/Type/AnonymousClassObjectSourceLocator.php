<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract;
use TenantCloud\BetterReflection\Relocated\PhpParser\Parser;
use ReflectionClass as CoreReflectionClass;
use ReflectionException;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\EvaledAnonymousClassCannotBeLocated;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\TwoAnonymousClassesOnSameLine;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper;
use function array_filter;
use function array_values;
use function assert;
use function file_get_contents;
use function gettype;
use function is_object;
use function sprintf;
use function strpos;
/**
 * @internal
 */
final class AnonymousClassObjectSourceLocator implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var CoreReflectionClass */
    private $coreClassReflection;
    /** @var Parser */
    private $parser;
    /**
     * @param object $anonymousClassObject
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @psalm-suppress DocblockTypeContradiction
     */
    public function __construct($anonymousClassObject, \TenantCloud\BetterReflection\Relocated\PhpParser\Parser $parser)
    {
        if (!\is_object($anonymousClassObject)) {
            throw new \InvalidArgumentException(\sprintf('Can only create from an instance of an object, "%s" given', \gettype($anonymousClassObject)));
        }
        $this->coreClassReflection = new \ReflectionClass($anonymousClassObject);
        $this->parser = $parser;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        return $this->getReflectionClass($reflector, $identifier->getType());
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifiersByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return \array_filter([$this->getReflectionClass($reflector, $identifierType)]);
    }
    private function getReflectionClass(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass
    {
        if (!$identifierType->isClass()) {
            return null;
        }
        $fileName = $this->coreClassReflection->getFileName();
        if (\strpos($fileName, 'eval()\'d code') !== \false) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\EvaledAnonymousClassCannotBeLocated::create();
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        $fileName = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper::normalizeWindowsPath($fileName);
        $nodeVisitor = new class($fileName, $this->coreClassReflection->getStartLine()) extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeVisitorAbstract
        {
            /** @var string */
            private $fileName;
            /** @var int */
            private $startLine;
            /** @var Class_[] */
            private $anonymousClassNodes = [];
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
                if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ || $node->name !== null) {
                    return null;
                }
                $this->anonymousClassNodes[] = $node;
                return null;
            }
            public function getAnonymousClassNode() : ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_
            {
                /** @var Class_[] $anonymousClassNodesOnSameLine */
                $anonymousClassNodesOnSameLine = \array_values(\array_filter($this->anonymousClassNodes, function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $node) : bool {
                    return $node->getLine() === $this->startLine;
                }));
                if (!$anonymousClassNodesOnSameLine) {
                    return null;
                }
                if (isset($anonymousClassNodesOnSameLine[1])) {
                    throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\TwoAnonymousClassesOnSameLine::create($this->fileName, $this->startLine);
                }
                return $anonymousClassNodesOnSameLine[0];
            }
        };
        $fileContents = \file_get_contents($fileName);
        $ast = $this->parser->parse($fileContents);
        $nodeTraverser = new \TenantCloud\BetterReflection\Relocated\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($nodeVisitor);
        $nodeTraverser->traverse($ast);
        $reflectionClass = (new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection())->__invoke($reflector, $nodeVisitor->getAnonymousClassNode(), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource($fileContents, $fileName), null);
        \assert($reflectionClass instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass || $reflectionClass === null);
        return $reflectionClass;
    }
}
