<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
class OptimizedSingleFileSourceLocator implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher;
    private string $fileName;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult $fetchedNodesResult = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher, string $fileName)
    {
        $this->fileNodesFetcher = $fileNodesFetcher;
        $this->fileName = $fileName;
    }
    public function locateIdentifier(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        if ($this->fetchedNodesResult === null) {
            $this->fetchedNodesResult = $this->fileNodesFetcher->fetchNodes($this->fileName);
        }
        $nodeToReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection();
        if ($identifier->isClass()) {
            $classNodes = $this->fetchedNodesResult->getClassNodes();
            $className = \strtolower($identifier->getName());
            if (!\array_key_exists($className, $classNodes)) {
                return null;
            }
            foreach ($classNodes[$className] as $classNode) {
                $classReflection = $nodeToReflection->__invoke($reflector, $classNode->getNode(), $this->fetchedNodesResult->getLocatedSource(), $classNode->getNamespace());
                if (!$classReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
                return $classReflection;
            }
        }
        if ($identifier->isFunction()) {
            $functionNodes = $this->fetchedNodesResult->getFunctionNodes();
            $functionName = \strtolower($identifier->getName());
            if (!\array_key_exists($functionName, $functionNodes)) {
                return null;
            }
            $functionReflection = $nodeToReflection->__invoke($reflector, $functionNodes[$functionName]->getNode(), $this->fetchedNodesResult->getLocatedSource(), $functionNodes[$functionName]->getNamespace());
            if (!$functionReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            return $functionReflection;
        }
        if ($identifier->isConstant()) {
            $constantNodes = $this->fetchedNodesResult->getConstantNodes();
            foreach ($constantNodes as $stmtConst) {
                if ($stmtConst->getNode() instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
                    $constantReflection = $nodeToReflection->__invoke($reflector, $stmtConst->getNode(), $this->fetchedNodesResult->getLocatedSource(), $stmtConst->getNamespace());
                    if ($constantReflection === null) {
                        continue;
                    }
                    if (!$constantReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant) {
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                    }
                    if ($constantReflection->getName() !== $identifier->getName()) {
                        continue;
                    }
                    return $constantReflection;
                }
                foreach (\array_keys($stmtConst->getNode()->consts) as $i) {
                    $constantReflection = $nodeToReflection->__invoke($reflector, $stmtConst->getNode(), $this->fetchedNodesResult->getLocatedSource(), $stmtConst->getNamespace(), $i);
                    if ($constantReflection === null) {
                        continue;
                    }
                    if (!$constantReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant) {
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                    }
                    if ($constantReflection->getName() !== $identifier->getName()) {
                        continue;
                    }
                    return $constantReflection;
                }
            }
            return null;
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function locateIdentifiersByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return [];
    }
}
