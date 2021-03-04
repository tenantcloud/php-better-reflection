<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Dependency;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Foreach_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\InFunctionNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionWithFilename;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
class DependencyResolver
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver)
    {
        $this->fileHelper = $fileHelper;
        $this->reflectionProvider = $reflectionProvider;
        $this->exportedNodeResolver = $exportedNodeResolver;
    }
    public function resolveDependencies(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\NodeDependencies
    {
        $dependenciesReflections = [];
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_) {
            if ($node->extends !== null) {
                $this->addClassToDependencies($node->extends->toString(), $dependenciesReflections);
            }
            foreach ($node->implements as $className) {
                $this->addClassToDependencies($className->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Interface_) {
            foreach ($node->extends as $className) {
                $this->addClassToDependencies($className->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassMethodNode) {
            $nativeMethod = $scope->getFunction();
            if ($nativeMethod !== null) {
                $parametersAcceptor = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($nativeMethod->getVariants());
                if ($parametersAcceptor instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                    $this->extractFromParametersAcceptor($parametersAcceptor, $dependenciesReflections);
                }
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InFunctionNode) {
            $functionReflection = $scope->getFunction();
            if ($functionReflection !== null) {
                $parametersAcceptor = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants());
                if ($parametersAcceptor instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                    $this->extractFromParametersAcceptor($parametersAcceptor, $dependenciesReflections);
                }
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure) {
            /** @var ClosureType $closureType */
            $closureType = $scope->getType($node);
            foreach ($closureType->getParameters() as $parameter) {
                $referencedClasses = $parameter->getType()->getReferencedClasses();
                foreach ($referencedClasses as $referencedClass) {
                    $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                }
            }
            $returnTypeReferencedClasses = $closureType->getReturnType()->getReferencedClasses();
            foreach ($returnTypeReferencedClasses as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
            $functionName = $node->name;
            if ($functionName instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
                try {
                    $dependenciesReflections[] = $this->getFunctionReflection($functionName, $scope);
                } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\FunctionNotFoundException $e) {
                    // pass
                }
            } else {
                $calledType = $scope->getType($functionName);
                if ($calledType->isCallable()->yes()) {
                    $variants = $calledType->getCallableParametersAcceptors($scope);
                    foreach ($variants as $variant) {
                        $referencedClasses = $variant->getReturnType()->getReferencedClasses();
                        foreach ($referencedClasses as $referencedClass) {
                            $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                        }
                    }
                }
            }
            $returnType = $scope->getType($node);
            foreach ($returnType->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
            $classNames = $scope->getType($node->var)->getReferencedClasses();
            foreach ($classNames as $className) {
                $this->addClassToDependencies($className, $dependenciesReflections);
            }
            $returnType = $scope->getType($node);
            foreach ($returnType->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
            if ($node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
                $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
            } else {
                foreach ($scope->getType($node->class)->getReferencedClasses() as $referencedClass) {
                    $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                }
            }
            $returnType = $scope->getType($node);
            foreach ($returnType->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_ && $node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\TraitUse) {
            foreach ($node->traits as $traitName) {
                $this->addClassToDependencies($traitName->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_) {
            if ($node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
                $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Catch_) {
            foreach ($node->types as $type) {
                $this->addClassToDependencies($scope->resolveName($type), $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch && $node->dim !== null) {
            $varType = $scope->getType($node->var);
            $dimType = $scope->getType($node->dim);
            foreach ($varType->getOffsetValueType($dimType)->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Foreach_) {
            $exprType = $scope->getType($node->expr);
            if ($node->keyVar !== null) {
                foreach ($exprType->getIterableKeyType()->getReferencedClasses() as $referencedClass) {
                    $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                }
            }
            foreach ($exprType->getIterableValueType()->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_ && $this->considerArrayForCallableTest($scope, $node)) {
            $arrayType = $scope->getType($node);
            if (!$arrayType->isCallable()->no()) {
                foreach ($arrayType->getCallableParametersAcceptors($scope) as $variant) {
                    $referencedClasses = $variant->getReturnType()->getReferencedClasses();
                    foreach ($referencedClasses as $referencedClass) {
                        $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                    }
                }
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Dependency\NodeDependencies($this->fileHelper, $dependenciesReflections, $this->exportedNodeResolver->resolve($scope->getFile(), $node));
    }
    private function considerArrayForCallableTest(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_ $arrayNode) : bool
    {
        if (!isset($arrayNode->items[0])) {
            return \false;
        }
        $itemType = $scope->getType($arrayNode->items[0]->value);
        if (!$itemType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            return \true;
        }
        return $itemType->isClassString();
    }
    /**
     * @param string $className
     * @param ReflectionWithFilename[] $dependenciesReflections
     */
    private function addClassToDependencies(string $className, array &$dependenciesReflections) : void
    {
        try {
            $classReflection = $this->reflectionProvider->getClass($className);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException $e) {
            return;
        }
        do {
            $dependenciesReflections[] = $classReflection;
            foreach ($classReflection->getInterfaces() as $interface) {
                $dependenciesReflections[] = $interface;
            }
            foreach ($classReflection->getTraits() as $trait) {
                $dependenciesReflections[] = $trait;
            }
            $classReflection = $classReflection->getParentClass();
        } while ($classReflection !== \false);
    }
    private function getFunctionReflection(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionWithFilename
    {
        $reflection = $this->reflectionProvider->getFunction($nameNode, $scope);
        if (!$reflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionWithFilename) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
        }
        return $reflection;
    }
    /**
     * @param ParametersAcceptorWithPhpDocs $parametersAcceptor
     * @param ReflectionWithFilename[] $dependenciesReflections
     */
    private function extractFromParametersAcceptor(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parametersAcceptor, array &$dependenciesReflections) : void
    {
        foreach ($parametersAcceptor->getParameters() as $parameter) {
            $referencedClasses = \array_merge($parameter->getNativeType()->getReferencedClasses(), $parameter->getPhpDocType()->getReferencedClasses());
            foreach ($referencedClasses as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        }
        $returnTypeReferencedClasses = \array_merge($parametersAcceptor->getNativeReturnType()->getReferencedClasses(), $parametersAcceptor->getPhpDocReturnType()->getReferencedClasses());
        foreach ($returnTypeReferencedClasses as $referencedClass) {
            $this->addClassToDependencies($referencedClass, $dependenciesReflections);
        }
    }
}
