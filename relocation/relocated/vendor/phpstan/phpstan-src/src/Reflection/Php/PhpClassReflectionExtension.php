<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Declare_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionProperty;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodsClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterWithPhpDocsReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertiesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignature;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\ParameterSignature;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\SignatureMapProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class PhpClassReflectionExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertiesClassReflectionExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodsClassReflectionExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory $scopeFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflectionFactory $methodReflectionFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocInheritanceResolver $phpDocInheritanceResolver;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension $annotationsMethodsClassReflectionExtension;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension $annotationsPropertiesClassReflectionExtension;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\SignatureMapProvider $signatureMapProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider;
    private bool $inferPrivatePropertyTypeFromConstructor;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    /** @var string[] */
    private array $universalObjectCratesClasses;
    /** @var \PHPStan\Reflection\PropertyReflection[][] */
    private array $propertiesIncludingAnnotations = [];
    /** @var \PHPStan\Reflection\Php\PhpPropertyReflection[][] */
    private array $nativeProperties = [];
    /** @var \PHPStan\Reflection\MethodReflection[][] */
    private array $methodsIncludingAnnotations = [];
    /** @var \PHPStan\Reflection\MethodReflection[][] */
    private array $nativeMethods = [];
    /** @var array<string, array<string, Type>> */
    private array $propertyTypesCache = [];
    /** @var array<string, true> */
    private array $inferClassConstructorPropertyTypesInProcess = [];
    /**
     * @param \PHPStan\Analyser\ScopeFactory $scopeFactory
     * @param \PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver
     * @param \PHPStan\Reflection\Php\PhpMethodReflectionFactory $methodReflectionFactory
     * @param \PHPStan\PhpDoc\PhpDocInheritanceResolver $phpDocInheritanceResolver
     * @param \PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension $annotationsMethodsClassReflectionExtension
     * @param \PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension $annotationsPropertiesClassReflectionExtension
     * @param \PHPStan\Reflection\SignatureMap\SignatureMapProvider $signatureMapProvider
     * @param \PHPStan\Parser\Parser $parser
     * @param \PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param FileTypeMapper $fileTypeMapper
     * @param bool $inferPrivatePropertyTypeFromConstructor
     * @param string[] $universalObjectCratesClasses
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory $scopeFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflectionFactory $methodReflectionFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocInheritanceResolver $phpDocInheritanceResolver, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension $annotationsMethodsClassReflectionExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension $annotationsPropertiesClassReflectionExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\SignatureMapProvider $signatureMapProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, bool $inferPrivatePropertyTypeFromConstructor, array $universalObjectCratesClasses)
    {
        $this->scopeFactory = $scopeFactory;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->methodReflectionFactory = $methodReflectionFactory;
        $this->phpDocInheritanceResolver = $phpDocInheritanceResolver;
        $this->annotationsMethodsClassReflectionExtension = $annotationsMethodsClassReflectionExtension;
        $this->annotationsPropertiesClassReflectionExtension = $annotationsPropertiesClassReflectionExtension;
        $this->signatureMapProvider = $signatureMapProvider;
        $this->parser = $parser;
        $this->stubPhpDocProvider = $stubPhpDocProvider;
        $this->reflectionProvider = $reflectionProvider;
        $this->fileTypeMapper = $fileTypeMapper;
        $this->inferPrivatePropertyTypeFromConstructor = $inferPrivatePropertyTypeFromConstructor;
        $this->universalObjectCratesClasses = $universalObjectCratesClasses;
    }
    public function hasProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getNativeReflection()->hasProperty($propertyName);
    }
    public function getProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        if (!isset($this->propertiesIncludingAnnotations[$classReflection->getCacheKey()][$propertyName])) {
            $this->propertiesIncludingAnnotations[$classReflection->getCacheKey()][$propertyName] = $this->createProperty($classReflection, $propertyName, \true);
        }
        return $this->propertiesIncludingAnnotations[$classReflection->getCacheKey()][$propertyName];
    }
    public function getNativeProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection
    {
        if (!isset($this->nativeProperties[$classReflection->getCacheKey()][$propertyName])) {
            /** @var \PHPStan\Reflection\Php\PhpPropertyReflection $property */
            $property = $this->createProperty($classReflection, $propertyName, \false);
            $this->nativeProperties[$classReflection->getCacheKey()][$propertyName] = $property;
        }
        return $this->nativeProperties[$classReflection->getCacheKey()][$propertyName];
    }
    private function createProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName, bool $includingAnnotations) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        $propertyReflection = $classReflection->getNativeReflection()->getProperty($propertyName);
        $propertyName = $propertyReflection->getName();
        $declaringClassName = $propertyReflection->getDeclaringClass()->getName();
        $declaringClassReflection = $classReflection->getAncestorWithClassName($declaringClassName);
        if ($declaringClassReflection === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Internal error: Expected to find an ancestor with class name %s on %s, but none was found.', $declaringClassName, $classReflection->getName()));
        }
        $deprecatedDescription = null;
        $isDeprecated = \false;
        $isInternal = \false;
        if ($includingAnnotations && $this->annotationsPropertiesClassReflectionExtension->hasProperty($classReflection, $propertyName)) {
            $hierarchyDistances = $classReflection->getClassHierarchyDistances();
            $annotationProperty = $this->annotationsPropertiesClassReflectionExtension->getProperty($classReflection, $propertyName);
            if (!isset($hierarchyDistances[$annotationProperty->getDeclaringClass()->getName()])) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $distanceDeclaringClass = $propertyReflection->getDeclaringClass()->getName();
            $propertyTrait = $this->findPropertyTrait($propertyReflection);
            if ($propertyTrait !== null) {
                $distanceDeclaringClass = $propertyTrait;
            }
            if (!isset($hierarchyDistances[$distanceDeclaringClass])) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            if ($hierarchyDistances[$annotationProperty->getDeclaringClass()->getName()] < $hierarchyDistances[$distanceDeclaringClass]) {
                return $annotationProperty;
            }
        }
        $docComment = $propertyReflection->getDocComment() !== \false ? $propertyReflection->getDocComment() : null;
        $declaringTraitName = null;
        $phpDocType = null;
        $resolvedPhpDoc = $this->stubPhpDocProvider->findPropertyPhpDoc($declaringClassName, $propertyReflection->getName());
        $stubPhpDocString = null;
        if ($resolvedPhpDoc === null) {
            if ($declaringClassReflection->getFileName() !== \false) {
                $declaringTraitName = $this->findPropertyTrait($propertyReflection);
                $constructorName = null;
                if (\method_exists($propertyReflection, 'isPromoted') && $propertyReflection->isPromoted()) {
                    if ($declaringClassReflection->hasConstructor()) {
                        $constructorName = $declaringClassReflection->getConstructor()->getName();
                    }
                }
                if ($constructorName === null) {
                    $resolvedPhpDoc = $this->phpDocInheritanceResolver->resolvePhpDocForProperty($docComment, $declaringClassReflection, $declaringClassReflection->getFileName(), $declaringTraitName, $propertyName);
                } elseif ($docComment !== null) {
                    $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($declaringClassReflection->getFileName(), $declaringClassName, $declaringTraitName, $constructorName, $docComment);
                }
                $phpDocBlockClassReflection = $declaringClassReflection;
            }
        } else {
            $phpDocBlockClassReflection = $declaringClassReflection;
            $stubPhpDocString = $resolvedPhpDoc->getPhpDocString();
        }
        if ($resolvedPhpDoc !== null) {
            $varTags = $resolvedPhpDoc->getVarTags();
            if (isset($varTags[0]) && \count($varTags) === 1) {
                $phpDocType = $varTags[0]->getType();
            } elseif (isset($varTags[$propertyName])) {
                $phpDocType = $varTags[$propertyName]->getType();
            }
        }
        if ($phpDocType === null) {
            if (isset($constructorName) && $declaringClassReflection->getFileName() !== \false) {
                $constructorDocComment = $declaringClassReflection->getConstructor()->getDocComment();
                $nativeClassReflection = $declaringClassReflection->getNativeReflection();
                $positionalParameterNames = [];
                if ($nativeClassReflection->getConstructor() !== null) {
                    $positionalParameterNames = \array_map(static function (\ReflectionParameter $parameter) : string {
                        return $parameter->getName();
                    }, $nativeClassReflection->getConstructor()->getParameters());
                }
                $resolvedPhpDoc = $this->phpDocInheritanceResolver->resolvePhpDocForMethod($constructorDocComment, $declaringClassReflection->getFileName(), $declaringClassReflection, $declaringTraitName, $constructorName, $positionalParameterNames);
                $paramTags = $resolvedPhpDoc->getParamTags();
                if (isset($paramTags[$propertyReflection->getName()])) {
                    $phpDocType = $paramTags[$propertyReflection->getName()]->getType();
                }
            }
        }
        if ($resolvedPhpDoc !== null) {
            if (!isset($phpDocBlockClassReflection)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $phpDocType = $phpDocType !== null ? \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($phpDocType, $phpDocBlockClassReflection->getActiveTemplateTypeMap()) : null;
            $deprecatedDescription = $resolvedPhpDoc->getDeprecatedTag() !== null ? $resolvedPhpDoc->getDeprecatedTag()->getMessage() : null;
            $isDeprecated = $resolvedPhpDoc->isDeprecated();
            $isInternal = $resolvedPhpDoc->isInternal();
        }
        if ($phpDocType === null && $this->inferPrivatePropertyTypeFromConstructor && $declaringClassReflection->getFileName() !== \false && $propertyReflection->isPrivate() && (!\method_exists($propertyReflection, 'hasType') || !$propertyReflection->hasType()) && $declaringClassReflection->hasConstructor() && $declaringClassReflection->getConstructor()->getDeclaringClass()->getName() === $declaringClassReflection->getName()) {
            $phpDocType = $this->inferPrivatePropertyType($propertyReflection->getName(), $declaringClassReflection->getConstructor());
        }
        $nativeType = null;
        if (\method_exists($propertyReflection, 'getType') && $propertyReflection->getType() !== null) {
            $nativeType = $propertyReflection->getType();
        }
        $declaringTrait = null;
        if ($declaringTraitName !== null && $this->reflectionProvider->hasClass($declaringTraitName)) {
            $declaringTrait = $this->reflectionProvider->getClass($declaringTraitName);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection($declaringClassReflection, $declaringTrait, $nativeType, $phpDocType, $propertyReflection, $deprecatedDescription, $isDeprecated, $isInternal, $stubPhpDocString);
    }
    public function hasMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        return $classReflection->getNativeReflection()->hasMethod($methodName);
    }
    public function getMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        if (isset($this->methodsIncludingAnnotations[$classReflection->getCacheKey()][$methodName])) {
            return $this->methodsIncludingAnnotations[$classReflection->getCacheKey()][$methodName];
        }
        $nativeMethodReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\NativeBuiltinMethodReflection($classReflection->getNativeReflection()->getMethod($methodName));
        if (!isset($this->methodsIncludingAnnotations[$classReflection->getCacheKey()][$nativeMethodReflection->getName()])) {
            $method = $this->createMethod($classReflection, $nativeMethodReflection, \true);
            $this->methodsIncludingAnnotations[$classReflection->getCacheKey()][$nativeMethodReflection->getName()] = $method;
            if ($nativeMethodReflection->getName() !== $methodName) {
                $this->methodsIncludingAnnotations[$classReflection->getCacheKey()][$methodName] = $method;
            }
        }
        return $this->methodsIncludingAnnotations[$classReflection->getCacheKey()][$nativeMethodReflection->getName()];
    }
    public function hasNativeMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        $hasMethod = $this->hasMethod($classReflection, $methodName);
        if ($hasMethod) {
            return \true;
        }
        if ($methodName === '__get' && \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension::isUniversalObjectCrate($this->reflectionProvider, $this->universalObjectCratesClasses, $classReflection)) {
            return \true;
        }
        return \false;
    }
    public function getNativeMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        if (isset($this->nativeMethods[$classReflection->getCacheKey()][$methodName])) {
            return $this->nativeMethods[$classReflection->getCacheKey()][$methodName];
        }
        if ($classReflection->getNativeReflection()->hasMethod($methodName)) {
            $nativeMethodReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\NativeBuiltinMethodReflection($classReflection->getNativeReflection()->getMethod($methodName));
        } else {
            if ($methodName !== '__get' || !\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension::isUniversalObjectCrate($this->reflectionProvider, $this->universalObjectCratesClasses, $classReflection)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $nativeMethodReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\FakeBuiltinMethodReflection($methodName, $classReflection->getNativeReflection());
        }
        if (!isset($this->nativeMethods[$classReflection->getCacheKey()][$nativeMethodReflection->getName()])) {
            $method = $this->createMethod($classReflection, $nativeMethodReflection, \false);
            $this->nativeMethods[$classReflection->getCacheKey()][$nativeMethodReflection->getName()] = $method;
        }
        return $this->nativeMethods[$classReflection->getCacheKey()][$nativeMethodReflection->getName()];
    }
    private function createMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\BuiltinMethodReflection $methodReflection, bool $includingAnnotations) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        if ($includingAnnotations && $this->annotationsMethodsClassReflectionExtension->hasMethod($classReflection, $methodReflection->getName())) {
            $hierarchyDistances = $classReflection->getClassHierarchyDistances();
            $annotationMethod = $this->annotationsMethodsClassReflectionExtension->getMethod($classReflection, $methodReflection->getName());
            if (!isset($hierarchyDistances[$annotationMethod->getDeclaringClass()->getName()])) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $distanceDeclaringClass = $methodReflection->getDeclaringClass()->getName();
            $methodTrait = $this->findMethodTrait($methodReflection);
            if ($methodTrait !== null) {
                $distanceDeclaringClass = $methodTrait;
            }
            if (!isset($hierarchyDistances[$distanceDeclaringClass])) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            if ($hierarchyDistances[$annotationMethod->getDeclaringClass()->getName()] < $hierarchyDistances[$distanceDeclaringClass]) {
                return $annotationMethod;
            }
        }
        $declaringClassName = $methodReflection->getDeclaringClass()->getName();
        $declaringClass = $classReflection->getAncestorWithClassName($declaringClassName);
        if ($declaringClass === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Internal error: Expected to find an ancestor with class name %s on %s, but none was found.', $declaringClassName, $classReflection->getName()));
        }
        if ($this->signatureMapProvider->hasMethodSignature($declaringClassName, $methodReflection->getName())) {
            $variantNumbers = [];
            $i = 0;
            while ($this->signatureMapProvider->hasMethodSignature($declaringClassName, $methodReflection->getName(), $i)) {
                $variantNumbers[] = $i;
                $i++;
            }
            $stubPhpDocString = null;
            $variants = [];
            $reflectionMethod = null;
            $throwType = null;
            if ($classReflection->getNativeReflection()->hasMethod($methodReflection->getName())) {
                $reflectionMethod = $classReflection->getNativeReflection()->getMethod($methodReflection->getName());
            } elseif (\class_exists($classReflection->getName(), \false)) {
                $reflectionClass = new \ReflectionClass($classReflection->getName());
                if ($reflectionClass->hasMethod($methodReflection->getName())) {
                    $reflectionMethod = $reflectionClass->getMethod($methodReflection->getName());
                }
            }
            foreach ($variantNumbers as $variantNumber) {
                $methodSignature = $this->signatureMapProvider->getMethodSignature($declaringClassName, $methodReflection->getName(), $reflectionMethod, $variantNumber);
                $phpDocParameterNameMapping = [];
                foreach ($methodSignature->getParameters() as $parameter) {
                    $phpDocParameterNameMapping[$parameter->getName()] = $parameter->getName();
                }
                $stubPhpDocReturnType = null;
                $stubPhpDocParameterTypes = [];
                $stubPhpDocParameterVariadicity = [];
                $phpDocParameterTypes = [];
                $phpDocReturnType = null;
                if (\count($variantNumbers) === 1) {
                    $stubPhpDocPair = $this->findMethodPhpDocIncludingAncestors($declaringClass, $methodReflection->getName(), \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\ParameterSignature $parameterSignature) : string {
                        return $parameterSignature->getName();
                    }, $methodSignature->getParameters()));
                    if ($stubPhpDocPair !== null) {
                        [$stubPhpDoc, $stubDeclaringClass] = $stubPhpDocPair;
                        $stubPhpDocString = $stubPhpDoc->getPhpDocString();
                        $templateTypeMap = $stubDeclaringClass->getActiveTemplateTypeMap();
                        $returnTag = $stubPhpDoc->getReturnTag();
                        if ($returnTag !== null) {
                            $stubPhpDocReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($returnTag->getType(), $templateTypeMap);
                        }
                        foreach ($stubPhpDoc->getParamTags() as $name => $paramTag) {
                            $stubPhpDocParameterTypes[$name] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($paramTag->getType(), $templateTypeMap);
                            $stubPhpDocParameterVariadicity[$name] = $paramTag->isVariadic();
                        }
                    } elseif ($reflectionMethod !== null && $reflectionMethod->getDocComment() !== \false) {
                        $filename = $reflectionMethod->getFileName();
                        if ($filename !== \false) {
                            $phpDocBlock = $this->fileTypeMapper->getResolvedPhpDoc($filename, $declaringClassName, null, $reflectionMethod->getName(), $reflectionMethod->getDocComment());
                            $throwsTag = $phpDocBlock->getThrowsTag();
                            if ($throwsTag !== null) {
                                $throwType = $throwsTag->getType();
                            }
                            $returnTag = $phpDocBlock->getReturnTag();
                            if ($returnTag !== null) {
                                $phpDocReturnType = $returnTag->getType();
                            }
                            foreach ($phpDocBlock->getParamTags() as $name => $paramTag) {
                                $phpDocParameterTypes[$name] = $paramTag->getType();
                            }
                            $signatureParameters = $methodSignature->getParameters();
                            foreach ($reflectionMethod->getParameters() as $paramI => $reflectionParameter) {
                                if (!\array_key_exists($paramI, $signatureParameters)) {
                                    continue;
                                }
                                $phpDocParameterNameMapping[$signatureParameters[$paramI]->getName()] = $reflectionParameter->getName();
                            }
                        }
                    }
                }
                $variants[] = $this->createNativeMethodVariant($methodSignature, $stubPhpDocParameterTypes, $stubPhpDocParameterVariadicity, $stubPhpDocReturnType, $phpDocParameterTypes, $phpDocReturnType, $phpDocParameterNameMapping);
            }
            if ($this->signatureMapProvider->hasMethodMetadata($declaringClassName, $methodReflection->getName())) {
                $hasSideEffects = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($this->signatureMapProvider->getMethodMetadata($declaringClassName, $methodReflection->getName())['hasSideEffects']);
            } else {
                $hasSideEffects = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeMethodReflection($this->reflectionProvider, $declaringClass, $methodReflection, $variants, $hasSideEffects, $stubPhpDocString, $throwType);
        }
        $declaringTraitName = $this->findMethodTrait($methodReflection);
        $resolvedPhpDoc = null;
        $stubPhpDocPair = $this->findMethodPhpDocIncludingAncestors($declaringClass, $methodReflection->getName(), \array_map(static function (\ReflectionParameter $parameter) : string {
            return $parameter->getName();
        }, $methodReflection->getParameters()));
        $phpDocBlockClassReflection = $declaringClass;
        if ($stubPhpDocPair !== null) {
            [$resolvedPhpDoc, $phpDocBlockClassReflection] = $stubPhpDocPair;
        }
        $stubPhpDocString = null;
        if ($resolvedPhpDoc === null) {
            if ($declaringClass->getFileName() !== \false) {
                $docComment = $methodReflection->getDocComment();
                $positionalParameterNames = \array_map(static function (\ReflectionParameter $parameter) : string {
                    return $parameter->getName();
                }, $methodReflection->getParameters());
                $resolvedPhpDoc = $this->phpDocInheritanceResolver->resolvePhpDocForMethod($docComment, $declaringClass->getFileName(), $declaringClass, $declaringTraitName, $methodReflection->getName(), $positionalParameterNames);
                $phpDocBlockClassReflection = $declaringClass;
            }
        } else {
            $stubPhpDocString = $resolvedPhpDoc->getPhpDocString();
        }
        $declaringTrait = null;
        if ($declaringTraitName !== null && $this->reflectionProvider->hasClass($declaringTraitName)) {
            $declaringTrait = $this->reflectionProvider->getClass($declaringTraitName);
        }
        $templateTypeMap = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $phpDocParameterTypes = [];
        $phpDocReturnType = null;
        $phpDocThrowType = null;
        $deprecatedDescription = null;
        $isDeprecated = \false;
        $isInternal = \false;
        $isFinal = \false;
        $isPure = \false;
        if ($methodReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\NativeBuiltinMethodReflection && $methodReflection->isConstructor() && $declaringClass->getFileName() !== \false) {
            foreach ($methodReflection->getParameters() as $parameter) {
                if (!\method_exists($parameter, 'isPromoted') || !$parameter->isPromoted()) {
                    continue;
                }
                if (!$methodReflection->getDeclaringClass()->hasProperty($parameter->getName())) {
                    continue;
                }
                $parameterProperty = $methodReflection->getDeclaringClass()->getProperty($parameter->getName());
                if (!\method_exists($parameterProperty, 'isPromoted') || !$parameterProperty->isPromoted()) {
                    continue;
                }
                if ($parameterProperty->getDocComment() === \false) {
                    continue;
                }
                $propertyDocblock = $this->fileTypeMapper->getResolvedPhpDoc($declaringClass->getFileName(), $declaringClassName, $declaringTraitName, $methodReflection->getName(), $parameterProperty->getDocComment());
                $varTags = $propertyDocblock->getVarTags();
                if (isset($varTags[0]) && \count($varTags) === 1) {
                    $phpDocType = $varTags[0]->getType();
                } elseif (isset($varTags[$parameter->getName()])) {
                    $phpDocType = $varTags[$parameter->getName()]->getType();
                } else {
                    continue;
                }
                $phpDocParameterTypes[$parameter->getName()] = $phpDocType;
            }
        }
        if ($resolvedPhpDoc !== null) {
            $templateTypeMap = $resolvedPhpDoc->getTemplateTypeMap();
            foreach ($resolvedPhpDoc->getParamTags() as $paramName => $paramTag) {
                if (\array_key_exists($paramName, $phpDocParameterTypes)) {
                    continue;
                }
                $phpDocParameterTypes[$paramName] = $paramTag->getType();
            }
            foreach ($phpDocParameterTypes as $paramName => $paramType) {
                $phpDocParameterTypes[$paramName] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($paramType, $phpDocBlockClassReflection->getActiveTemplateTypeMap());
            }
            $nativeReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideTypeFromReflection($methodReflection->getReturnType(), null, $declaringClass->getName());
            $phpDocReturnType = $this->getPhpDocReturnType($phpDocBlockClassReflection, $resolvedPhpDoc, $nativeReturnType);
            $phpDocThrowType = $resolvedPhpDoc->getThrowsTag() !== null ? $resolvedPhpDoc->getThrowsTag()->getType() : null;
            $deprecatedDescription = $resolvedPhpDoc->getDeprecatedTag() !== null ? $resolvedPhpDoc->getDeprecatedTag()->getMessage() : null;
            $isDeprecated = $resolvedPhpDoc->isDeprecated();
            $isInternal = $resolvedPhpDoc->isInternal();
            $isFinal = $resolvedPhpDoc->isFinal();
            $isPure = $resolvedPhpDoc->isPure();
        }
        return $this->methodReflectionFactory->create($declaringClass, $declaringTrait, $methodReflection, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $stubPhpDocString, $isPure);
    }
    /**
     * @param FunctionSignature $methodSignature
     * @param array<string, Type> $stubPhpDocParameterTypes
     * @param array<string, bool> $stubPhpDocParameterVariadicity
     * @param Type|null $stubPhpDocReturnType
     * @param array<string, Type> $phpDocParameterTypes
     * @param Type|null $phpDocReturnType
     * @param array<string, string> $phpDocParameterNameMapping
     * @return FunctionVariantWithPhpDocs
     */
    private function createNativeMethodVariant(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignature $methodSignature, array $stubPhpDocParameterTypes, array $stubPhpDocParameterVariadicity, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $stubPhpDocReturnType, array $phpDocParameterTypes, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType, array $phpDocParameterNameMapping) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariantWithPhpDocs
    {
        $parameters = [];
        foreach ($methodSignature->getParameters() as $parameterSignature) {
            $type = null;
            $phpDocType = null;
            $phpDocParameterName = $phpDocParameterNameMapping[$parameterSignature->getName()] ?? $parameterSignature->getName();
            if (isset($stubPhpDocParameterTypes[$parameterSignature->getName()])) {
                $type = $stubPhpDocParameterTypes[$parameterSignature->getName()];
                $phpDocType = $stubPhpDocParameterTypes[$parameterSignature->getName()];
            } elseif (isset($phpDocParameterTypes[$phpDocParameterName])) {
                $phpDocType = $phpDocParameterTypes[$phpDocParameterName];
            }
            $parameters[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterWithPhpDocsReflection($phpDocParameterName, $parameterSignature->isOptional(), $type ?? $parameterSignature->getType(), $phpDocType ?? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $parameterSignature->getNativeType(), $parameterSignature->passedByReference(), $stubPhpDocParameterVariadicity[$parameterSignature->getName()] ?? $parameterSignature->isVariadic(), null);
        }
        $returnType = null;
        if ($stubPhpDocReturnType !== null) {
            $returnType = $stubPhpDocReturnType;
            $phpDocReturnType = $stubPhpDocReturnType;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariantWithPhpDocs(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, $parameters, $methodSignature->isVariadic(), $returnType ?? $methodSignature->getReturnType(), $phpDocReturnType ?? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $methodSignature->getNativeReturnType());
    }
    private function findPropertyTrait(\ReflectionProperty $propertyReflection) : ?string
    {
        if ($propertyReflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionProperty) {
            $declaringClass = $propertyReflection->getBetterReflection()->getDeclaringClass();
            if ($declaringClass->isTrait()) {
                if ($propertyReflection->getDeclaringClass()->isTrait() && $propertyReflection->getDeclaringClass()->getName() === $declaringClass->getName()) {
                    return null;
                }
                return $declaringClass->getName();
            }
            return null;
        }
        $declaringClass = $propertyReflection->getDeclaringClass();
        $trait = $this->deepScanTraitsForProperty($declaringClass->getTraits(), $propertyReflection);
        if ($trait !== null) {
            return $trait;
        }
        return null;
    }
    /**
     * @param \ReflectionClass<object>[] $traits
     * @param \ReflectionProperty $propertyReflection
     * @return string|null
     */
    private function deepScanTraitsForProperty(array $traits, \ReflectionProperty $propertyReflection) : ?string
    {
        foreach ($traits as $trait) {
            $result = $this->deepScanTraitsForProperty($trait->getTraits(), $propertyReflection);
            if ($result !== null) {
                return $result;
            }
            if (!$trait->hasProperty($propertyReflection->getName())) {
                continue;
            }
            $traitProperty = $trait->getProperty($propertyReflection->getName());
            if ($traitProperty->getDocComment() === $propertyReflection->getDocComment()) {
                return $trait->getName();
            }
        }
        return null;
    }
    private function findMethodTrait(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\BuiltinMethodReflection $methodReflection) : ?string
    {
        if ($methodReflection->getReflection() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionMethod) {
            $declaringClass = $methodReflection->getReflection()->getBetterReflection()->getDeclaringClass();
            if ($declaringClass->isTrait()) {
                if ($methodReflection->getDeclaringClass()->isTrait() && $declaringClass->getName() === $methodReflection->getDeclaringClass()->getName()) {
                    return null;
                }
                return $declaringClass->getName();
            }
            return null;
        }
        $declaringClass = $methodReflection->getDeclaringClass();
        if ($methodReflection->getFileName() === $declaringClass->getFileName() && $methodReflection->getStartLine() >= $declaringClass->getStartLine() && $methodReflection->getEndLine() <= $declaringClass->getEndLine()) {
            return null;
        }
        $declaringClass = $methodReflection->getDeclaringClass();
        $traitAliases = $declaringClass->getTraitAliases();
        if (\array_key_exists($methodReflection->getName(), $traitAliases)) {
            return \explode('::', $traitAliases[$methodReflection->getName()])[0];
        }
        foreach ($this->collectTraits($declaringClass) as $traitReflection) {
            if (!$traitReflection->hasMethod($methodReflection->getName())) {
                continue;
            }
            if ($methodReflection->getFileName() === $traitReflection->getFileName() && $methodReflection->getStartLine() >= $traitReflection->getStartLine() && $methodReflection->getEndLine() <= $traitReflection->getEndLine()) {
                return $traitReflection->getName();
            }
        }
        return null;
    }
    /**
     * @param \ReflectionClass $class
     * @return \ReflectionClass[]
     */
    private function collectTraits(\ReflectionClass $class) : array
    {
        $traits = [];
        $traitsLeftToAnalyze = $class->getTraits();
        while (\count($traitsLeftToAnalyze) !== 0) {
            $trait = \reset($traitsLeftToAnalyze);
            $traits[] = $trait;
            foreach ($trait->getTraits() as $subTrait) {
                if (\in_array($subTrait, $traits, \true)) {
                    continue;
                }
                $traitsLeftToAnalyze[] = $subTrait;
            }
            \array_shift($traitsLeftToAnalyze);
        }
        return $traits;
    }
    private function inferPrivatePropertyType(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $constructor) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $declaringClassName = $constructor->getDeclaringClass()->getName();
        if (isset($this->inferClassConstructorPropertyTypesInProcess[$declaringClassName])) {
            return null;
        }
        $this->inferClassConstructorPropertyTypesInProcess[$declaringClassName] = \true;
        $propertyTypes = $this->inferAndCachePropertyTypes($constructor);
        unset($this->inferClassConstructorPropertyTypesInProcess[$declaringClassName]);
        if (\array_key_exists($propertyName, $propertyTypes)) {
            return $propertyTypes[$propertyName];
        }
        return null;
    }
    /**
     * @param \PHPStan\Reflection\MethodReflection $constructor
     * @return array<string, Type>
     */
    private function inferAndCachePropertyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $constructor) : array
    {
        $declaringClass = $constructor->getDeclaringClass();
        if (isset($this->propertyTypesCache[$declaringClass->getName()])) {
            return $this->propertyTypesCache[$declaringClass->getName()];
        }
        if ($declaringClass->getFileName() === \false) {
            return $this->propertyTypesCache[$declaringClass->getName()] = [];
        }
        $fileName = $declaringClass->getFileName();
        $nodes = $this->parser->parseFile($fileName);
        $classNode = $this->findClassNode($declaringClass->getName(), $nodes);
        if ($classNode === null) {
            return $this->propertyTypesCache[$declaringClass->getName()] = [];
        }
        $methodNode = $this->findConstructorNode($constructor->getName(), $classNode->stmts);
        if ($methodNode === null || $methodNode->stmts === null) {
            return $this->propertyTypesCache[$declaringClass->getName()] = [];
        }
        $classNameParts = \explode('\\', $declaringClass->getName());
        $namespace = null;
        if (\count($classNameParts) > 1) {
            $namespace = \implode('\\', \array_slice($classNameParts, 0, -1));
        }
        $classScope = $this->scopeFactory->create(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeContext::create($fileName), \false, [], $constructor, $namespace)->enterClass($declaringClass);
        [$templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $isPure] = $this->nodeScopeResolver->getPhpDocs($classScope, $methodNode);
        $methodScope = $classScope->enterClassMethod($methodNode, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $isPure);
        $propertyTypes = [];
        foreach ($methodNode->stmts as $statement) {
            if (!$statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $expr = $statement->expr;
            if (!$expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign) {
                continue;
            }
            if (!$expr->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
                continue;
            }
            $propertyFetch = $expr->var;
            if (!$propertyFetch->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || $propertyFetch->var->name !== 'this' || !$propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
                continue;
            }
            $propertyType = $methodScope->getType($expr->expr);
            if ($propertyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType || $propertyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
                continue;
            }
            $propertyType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($propertyType);
            if ($propertyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                $propertyType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true));
            }
            $propertyTypes[$propertyFetch->name->toString()] = $propertyType;
        }
        return $this->propertyTypesCache[$declaringClass->getName()] = $propertyTypes;
    }
    /**
     * @param string $className
     * @param \PhpParser\Node[] $nodes
     * @return \PhpParser\Node\Stmt\Class_|null
     */
    private function findClassNode(string $className, array $nodes) : ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_
    {
        foreach ($nodes as $node) {
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ && $node->namespacedName->toString() === $className) {
                return $node;
            }
            if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Declare_) {
                continue;
            }
            $subNodeNames = $node->getSubNodeNames();
            foreach ($subNodeNames as $subNodeName) {
                $subNode = $node->{$subNodeName};
                if (!\is_array($subNode)) {
                    $subNode = [$subNode];
                }
                $result = $this->findClassNode($className, $subNode);
                if ($result === null) {
                    continue;
                }
                return $result;
            }
        }
        return null;
    }
    /**
     * @param string $methodName
     * @param \PhpParser\Node\Stmt[] $classStatements
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    private function findConstructorNode(string $methodName, array $classStatements) : ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod
    {
        foreach ($classStatements as $statement) {
            if ($statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod && $statement->name->toString() === $methodName) {
                return $statement;
            }
        }
        return null;
    }
    private function getPhpDocReturnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $phpDocBlockClassReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock $resolvedPhpDoc, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $returnTag = $resolvedPhpDoc->getReturnTag();
        if ($returnTag === null) {
            return null;
        }
        $phpDocReturnType = $returnTag->getType();
        $phpDocReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($phpDocReturnType, $phpDocBlockClassReflection->getActiveTemplateTypeMap());
        if ($returnTag->isExplicit() || $nativeReturnType->isSuperTypeOf($phpDocReturnType)->yes()) {
            return $phpDocReturnType;
        }
        return null;
    }
    /**
     * @param ClassReflection $declaringClass
     * @param string $methodName
     * @param array<int, string> $positionalParameterNames
     * @return array{\PHPStan\PhpDoc\ResolvedPhpDocBlock, ClassReflection}|null
     */
    private function findMethodPhpDocIncludingAncestors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, string $methodName, array $positionalParameterNames) : ?array
    {
        $declaringClassName = $declaringClass->getName();
        $resolved = $this->stubPhpDocProvider->findMethodPhpDoc($declaringClassName, $methodName, $positionalParameterNames);
        if ($resolved !== null) {
            return [$resolved, $declaringClass];
        }
        if (!$this->stubPhpDocProvider->isKnownClass($declaringClassName)) {
            return null;
        }
        $ancestors = $declaringClass->getAncestors();
        foreach ($ancestors as $ancestor) {
            if ($ancestor->getName() === $declaringClassName) {
                continue;
            }
            if (!$ancestor->hasNativeMethod($methodName)) {
                continue;
            }
            $resolved = $this->stubPhpDocProvider->findMethodPhpDoc($ancestor->getName(), $methodName, $positionalParameterNames);
            if ($resolved === null) {
                continue;
            }
            return [$resolved, $ancestor];
        }
        return null;
    }
}
