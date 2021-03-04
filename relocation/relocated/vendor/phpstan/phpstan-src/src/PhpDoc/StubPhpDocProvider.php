<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Interface_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Trait_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use function array_key_exists;
class StubPhpDocProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    /** @var string[] */
    private array $stubFiles;
    /** @var array<string, ResolvedPhpDocBlock|null> */
    private array $classMap = [];
    /** @var array<string, array<string, ResolvedPhpDocBlock|null>> */
    private array $propertyMap = [];
    /** @var array<string, array<string, null>> */
    private array $methodMap = [];
    /** @var array<string, ResolvedPhpDocBlock|null> */
    private array $functionMap = [];
    private bool $initialized = \false;
    private bool $initializing = \false;
    /** @var array<string, array{string, string}> */
    private array $knownClassesDocComments = [];
    /** @var array<string, array{string, string}> */
    private array $knownFunctionsDocComments = [];
    /** @var array<string, array<string, array{string, string}>> */
    private array $knownPropertiesDocComments = [];
    /** @var array<string, array<string, array{string, string}>> */
    private array $knownMethodsDocComments = [];
    /** @var array<string, array<string, array<string>>> */
    private array $knownMethodsParameterNames = [];
    /**
     * @param \PHPStan\Parser\Parser $parser
     * @param string[] $stubFiles
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, array $stubFiles)
    {
        $this->parser = $parser;
        $this->fileTypeMapper = $fileTypeMapper;
        $this->stubFiles = $stubFiles;
    }
    public function findClassPhpDoc(string $className) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        if (!$this->isKnownClass($className)) {
            return null;
        }
        if (\array_key_exists($className, $this->classMap)) {
            return $this->classMap[$className];
        }
        if (\array_key_exists($className, $this->knownClassesDocComments)) {
            [$file, $docComment] = $this->knownClassesDocComments[$className];
            $this->classMap[$className] = $this->fileTypeMapper->getResolvedPhpDoc($file, $className, null, null, $docComment);
            return $this->classMap[$className];
        }
        return null;
    }
    public function findPropertyPhpDoc(string $className, string $propertyName) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        if (!$this->isKnownClass($className)) {
            return null;
        }
        if (\array_key_exists($propertyName, $this->propertyMap[$className])) {
            return $this->propertyMap[$className][$propertyName];
        }
        if (\array_key_exists($propertyName, $this->knownPropertiesDocComments[$className])) {
            [$file, $docComment] = $this->knownPropertiesDocComments[$className][$propertyName];
            $this->propertyMap[$className][$propertyName] = $this->fileTypeMapper->getResolvedPhpDoc($file, $className, null, null, $docComment);
            return $this->propertyMap[$className][$propertyName];
        }
        return null;
    }
    /**
     * @param string $className
     * @param string $methodName
     * @param array<int, string> $positionalParameterNames
     * @return \PHPStan\PhpDoc\ResolvedPhpDocBlock|null
     */
    public function findMethodPhpDoc(string $className, string $methodName, array $positionalParameterNames) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        if (!$this->isKnownClass($className)) {
            return null;
        }
        if (\array_key_exists($methodName, $this->methodMap[$className])) {
            return $this->methodMap[$className][$methodName];
        }
        if (\array_key_exists($methodName, $this->knownMethodsDocComments[$className])) {
            [$file, $docComment] = $this->knownMethodsDocComments[$className][$methodName];
            $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($file, $className, null, $methodName, $docComment);
            if (!isset($this->knownMethodsParameterNames[$className][$methodName])) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $methodParameterNames = $this->knownMethodsParameterNames[$className][$methodName];
            $parameterNameMapping = [];
            foreach ($positionalParameterNames as $i => $parameterName) {
                if (!\array_key_exists($i, $methodParameterNames)) {
                    continue;
                }
                $parameterNameMapping[$methodParameterNames[$i]] = $parameterName;
            }
            return $resolvedPhpDoc->changeParameterNamesByMapping($parameterNameMapping);
        }
        return null;
    }
    public function findFunctionPhpDoc(string $functionName) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        if (!$this->isKnownFunction($functionName)) {
            return null;
        }
        if (\array_key_exists($functionName, $this->functionMap)) {
            return $this->functionMap[$functionName];
        }
        if (\array_key_exists($functionName, $this->knownFunctionsDocComments)) {
            [$file, $docComment] = $this->knownFunctionsDocComments[$functionName];
            $this->functionMap[$functionName] = $this->fileTypeMapper->getResolvedPhpDoc($file, null, null, $functionName, $docComment);
            return $this->functionMap[$functionName];
        }
        return null;
    }
    public function isKnownClass(string $className) : bool
    {
        $this->initializeKnownElements();
        if (\array_key_exists($className, $this->classMap)) {
            return \true;
        }
        return \array_key_exists($className, $this->knownClassesDocComments);
    }
    private function isKnownFunction(string $functionName) : bool
    {
        $this->initializeKnownElements();
        if (\array_key_exists($functionName, $this->functionMap)) {
            return \true;
        }
        return \array_key_exists($functionName, $this->knownFunctionsDocComments);
    }
    private function initializeKnownElements() : void
    {
        if ($this->initializing) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if ($this->initialized) {
            return;
        }
        $this->initializing = \true;
        foreach ($this->stubFiles as $stubFile) {
            $nodes = $this->parser->parseFile($stubFile);
            foreach ($nodes as $node) {
                $this->initializeKnownElementNode($stubFile, $node);
            }
        }
        $this->initializing = \false;
        $this->initialized = \true;
    }
    private function initializeKnownElementNode(string $stubFile, \TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : void
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_) {
            foreach ($node->stmts as $stmt) {
                $this->initializeKnownElementNode($stubFile, $stmt);
            }
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_) {
            $functionName = (string) $node->namespacedName;
            $docComment = $node->getDocComment();
            if ($docComment === null) {
                $this->functionMap[$functionName] = null;
                return;
            }
            $this->knownFunctionsDocComments[$functionName] = [$stubFile, $docComment->getText()];
            return;
        }
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Interface_ && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Trait_) {
            return;
        }
        if (!isset($node->namespacedName)) {
            return;
        }
        $className = (string) $node->namespacedName;
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            $this->classMap[$className] = null;
        } else {
            $this->knownClassesDocComments[$className] = [$stubFile, $docComment->getText()];
        }
        $this->methodMap[$className] = [];
        $this->propertyMap[$className] = [];
        $this->knownPropertiesDocComments[$className] = [];
        $this->knownMethodsDocComments[$className] = [];
        foreach ($node->stmts as $stmt) {
            $docComment = $stmt->getDocComment();
            if ($stmt instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Property) {
                foreach ($stmt->props as $property) {
                    if ($docComment === null) {
                        $this->propertyMap[$className][$property->name->toString()] = null;
                        continue;
                    }
                    $this->knownPropertiesDocComments[$className][$property->name->toString()] = [$stubFile, $docComment->getText()];
                }
            } elseif ($stmt instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod) {
                if ($docComment === null) {
                    $this->methodMap[$className][$stmt->name->toString()] = null;
                    continue;
                }
                $methodName = $stmt->name->toString();
                $this->knownMethodsDocComments[$className][$methodName] = [$stubFile, $docComment->getText()];
                $this->knownMethodsParameterNames[$className][$methodName] = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param $param) : string {
                    if (!$param->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                    }
                    return $param->var->name;
                }, $stmt->getParams());
            }
        }
    }
}
