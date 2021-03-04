<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use Attribute;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ExtendsTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ImplementsTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MethodTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\MixinTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\PropertyTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use ReflectionMethod;
class ClassReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionWithFilename
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    /** @var \PHPStan\Reflection\PropertiesClassReflectionExtension[] */
    private array $propertiesClassReflectionExtensions;
    /** @var \PHPStan\Reflection\MethodsClassReflectionExtension[] */
    private array $methodsClassReflectionExtensions;
    private string $displayName;
    private \ReflectionClass $reflection;
    private ?string $anonymousFilename;
    /** @var \PHPStan\Reflection\MethodReflection[] */
    private array $methods = [];
    /** @var \PHPStan\Reflection\PropertyReflection[] */
    private array $properties = [];
    /** @var \PHPStan\Reflection\ConstantReflection[] */
    private array $constants = [];
    /** @var int[]|null */
    private ?array $classHierarchyDistances = null;
    private ?string $deprecatedDescription = null;
    private ?bool $isDeprecated = null;
    private ?bool $isGeneric = null;
    private ?bool $isInternal = null;
    private ?bool $isFinal = null;
    /** @var ?TemplateTypeMap */
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap = null;
    /** @var ?TemplateTypeMap */
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock $stubPhpDocBlock;
    private ?string $extraCacheKey;
    /** @var array<string,ClassReflection>|null */
    private ?array $ancestors = null;
    private ?string $cacheKey = null;
    /** @var array<string, bool> */
    private array $subclasses = [];
    /** @var string|false|null */
    private $filename;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\Type\FileTypeMapper $fileTypeMapper
     * @param \PHPStan\Reflection\PropertiesClassReflectionExtension[] $propertiesClassReflectionExtensions
     * @param \PHPStan\Reflection\MethodsClassReflectionExtension[] $methodsClassReflectionExtensions
     * @param string $displayName
     * @param \ReflectionClass $reflection
     * @param string|null $anonymousFilename
     * @param ResolvedPhpDocBlock|null $stubPhpDocBlock
     * @param string|null $extraCacheKey
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion, array $propertiesClassReflectionExtensions, array $methodsClassReflectionExtensions, string $displayName, \ReflectionClass $reflection, ?string $anonymousFilename, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap, ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock $stubPhpDocBlock, ?string $extraCacheKey = null)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->fileTypeMapper = $fileTypeMapper;
        $this->phpVersion = $phpVersion;
        $this->propertiesClassReflectionExtensions = $propertiesClassReflectionExtensions;
        $this->methodsClassReflectionExtensions = $methodsClassReflectionExtensions;
        $this->displayName = $displayName;
        $this->reflection = $reflection;
        $this->anonymousFilename = $anonymousFilename;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
        $this->stubPhpDocBlock = $stubPhpDocBlock;
        $this->extraCacheKey = $extraCacheKey;
    }
    public function getNativeReflection() : \ReflectionClass
    {
        return $this->reflection;
    }
    /**
     * @return string|false
     */
    public function getFileName()
    {
        if (isset($this->filename)) {
            return $this->filename;
        }
        if ($this->anonymousFilename !== null) {
            return $this->filename = $this->anonymousFilename;
        }
        $fileName = $this->reflection->getFileName();
        if ($fileName === \false) {
            return $this->filename = \false;
        }
        if (!\file_exists($fileName)) {
            return $this->filename = \false;
        }
        return $this->filename = $fileName;
    }
    public function getFileNameWithPhpDocs() : ?string
    {
        if ($this->stubPhpDocBlock !== null) {
            return $this->stubPhpDocBlock->getFilename();
        }
        $filename = $this->getFileName();
        if ($filename === \false) {
            return null;
        }
        return $filename;
    }
    /**
     * @return false|\PHPStan\Reflection\ClassReflection
     */
    public function getParentClass()
    {
        $parentClass = $this->reflection->getParentClass();
        if ($parentClass === \false) {
            return \false;
        }
        $extendsTag = $this->getFirstExtendsTag();
        if ($extendsTag !== null && $this->isValidAncestorType($extendsTag->getType(), [$parentClass->getName()])) {
            $extendedType = $extendsTag->getType();
            if ($this->isGeneric()) {
                $extendedType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($extendedType, $this->getActiveTemplateTypeMap());
            }
            if (!$extendedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
                return $this->reflectionProvider->getClass($parentClass->getName());
            }
            return $extendedType->getClassReflection() ?? $this->reflectionProvider->getClass($parentClass->getName());
        }
        $parentReflection = $this->reflectionProvider->getClass($parentClass->getName());
        if ($parentReflection->isGeneric()) {
            return $parentReflection->withTypes(\array_values($parentReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()));
        }
        return $parentReflection;
    }
    /**
     * @return class-string
     */
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getDisplayName(bool $withTemplateTypes = \true) : string
    {
        $name = $this->displayName;
        if ($withTemplateTypes === \false || $this->resolvedTemplateTypeMap === null || \count($this->resolvedTemplateTypeMap->getTypes()) === 0) {
            return $name;
        }
        return $name . '<' . \implode(',', \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : string {
            return $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly());
        }, $this->resolvedTemplateTypeMap->getTypes())) . '>';
    }
    public function getCacheKey() : string
    {
        $cacheKey = $this->cacheKey;
        if ($cacheKey !== null) {
            return $this->cacheKey;
        }
        $cacheKey = $this->displayName;
        if ($this->resolvedTemplateTypeMap !== null) {
            $cacheKey .= '<' . \implode(',', \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : string {
                return $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::cache());
            }, $this->resolvedTemplateTypeMap->getTypes())) . '>';
        }
        if ($this->extraCacheKey !== null) {
            $cacheKey .= '-' . $this->extraCacheKey;
        }
        $this->cacheKey = $cacheKey;
        return $cacheKey;
    }
    /**
     * @return int[]
     */
    public function getClassHierarchyDistances() : array
    {
        if ($this->classHierarchyDistances === null) {
            $distance = 0;
            $distances = [$this->getName() => $distance];
            $currentClassReflection = $this->getNativeReflection();
            foreach ($this->collectTraits($this->getNativeReflection()) as $trait) {
                $distance++;
                if (\array_key_exists($trait->getName(), $distances)) {
                    continue;
                }
                $distances[$trait->getName()] = $distance;
            }
            while ($currentClassReflection->getParentClass() !== \false) {
                $distance++;
                $parentClassName = $currentClassReflection->getParentClass()->getName();
                if (!\array_key_exists($parentClassName, $distances)) {
                    $distances[$parentClassName] = $distance;
                }
                $currentClassReflection = $currentClassReflection->getParentClass();
                foreach ($this->collectTraits($currentClassReflection) as $trait) {
                    $distance++;
                    if (\array_key_exists($trait->getName(), $distances)) {
                        continue;
                    }
                    $distances[$trait->getName()] = $distance;
                }
            }
            foreach ($this->getNativeReflection()->getInterfaces() as $interface) {
                $distance++;
                if (\array_key_exists($interface->getName(), $distances)) {
                    continue;
                }
                $distances[$interface->getName()] = $distance;
            }
            $this->classHierarchyDistances = $distances;
        }
        return $this->classHierarchyDistances;
    }
    /**
     * @param \ReflectionClass<object> $class
     * @return \ReflectionClass<object>[]
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
    public function hasProperty(string $propertyName) : bool
    {
        foreach ($this->propertiesClassReflectionExtensions as $extension) {
            if ($extension->hasProperty($this, $propertyName)) {
                return \true;
            }
        }
        return \false;
    }
    public function hasMethod(string $methodName) : bool
    {
        foreach ($this->methodsClassReflectionExtensions as $extension) {
            if ($extension->hasMethod($this, $methodName)) {
                return \true;
            }
        }
        return \false;
    }
    public function getMethod(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $key = $methodName;
        if ($scope->isInClass()) {
            $key = \sprintf('%s-%s', $key, $scope->getClassReflection()->getCacheKey());
        }
        if (!isset($this->methods[$key])) {
            foreach ($this->methodsClassReflectionExtensions as $extension) {
                if (!$extension->hasMethod($this, $methodName)) {
                    continue;
                }
                $method = $extension->getMethod($this, $methodName);
                if ($scope->canCallMethod($method)) {
                    return $this->methods[$key] = $method;
                }
                $this->methods[$key] = $method;
            }
        }
        if (!isset($this->methods[$key])) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MissingMethodFromReflectionException($this->getName(), $methodName);
        }
        return $this->methods[$key];
    }
    public function hasNativeMethod(string $methodName) : bool
    {
        return $this->getPhpExtension()->hasNativeMethod($this, $methodName);
    }
    public function getNativeMethod(string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        if (!$this->hasNativeMethod($methodName)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MissingMethodFromReflectionException($this->getName(), $methodName);
        }
        return $this->getPhpExtension()->getNativeMethod($this, $methodName);
    }
    /**
     * @deprecated Use ClassReflection::getNativeReflection() instead.
     * @return MethodReflection[]
     */
    public function getNativeMethods() : array
    {
        $methods = [];
        foreach ($this->reflection->getMethods() as $method) {
            $methods[] = $this->getNativeMethod($method->getName());
        }
        return $methods;
    }
    public function hasConstructor() : bool
    {
        return $this->findConstructor() !== null;
    }
    public function getConstructor() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $constructor = $this->findConstructor();
        if ($constructor === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $this->getNativeMethod($constructor->getName());
    }
    private function findConstructor() : ?\ReflectionMethod
    {
        $constructor = $this->reflection->getConstructor();
        if ($constructor === null) {
            return null;
        }
        if ($this->phpVersion->supportsLegacyConstructor()) {
            return $constructor;
        }
        if (\strtolower($constructor->getName()) !== '__construct') {
            return null;
        }
        return $constructor;
    }
    private function getPhpExtension() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension
    {
        $extension = $this->methodsClassReflectionExtensions[0];
        if (!$extension instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $extension;
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        $key = $propertyName;
        if ($scope->isInClass()) {
            $key = \sprintf('%s-%s', $key, $scope->getClassReflection()->getCacheKey());
        }
        if (!isset($this->properties[$key])) {
            foreach ($this->propertiesClassReflectionExtensions as $extension) {
                if (!$extension->hasProperty($this, $propertyName)) {
                    continue;
                }
                $property = $extension->getProperty($this, $propertyName);
                if ($scope->canAccessProperty($property)) {
                    return $this->properties[$key] = $property;
                }
                $this->properties[$key] = $property;
            }
        }
        if (!isset($this->properties[$key])) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MissingPropertyFromReflectionException($this->getName(), $propertyName);
        }
        return $this->properties[$key];
    }
    public function hasNativeProperty(string $propertyName) : bool
    {
        return $this->getPhpExtension()->hasProperty($this, $propertyName);
    }
    public function getNativeProperty(string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection
    {
        if (!$this->hasNativeProperty($propertyName)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MissingPropertyFromReflectionException($this->getName(), $propertyName);
        }
        return $this->getPhpExtension()->getNativeProperty($this, $propertyName);
    }
    public function isAbstract() : bool
    {
        return $this->reflection->isAbstract();
    }
    public function isInterface() : bool
    {
        return $this->reflection->isInterface();
    }
    public function isTrait() : bool
    {
        return $this->reflection->isTrait();
    }
    public function isClass() : bool
    {
        return !$this->isInterface() && !$this->isTrait();
    }
    public function isAnonymous() : bool
    {
        return $this->anonymousFilename !== null;
    }
    public function isSubclassOf(string $className) : bool
    {
        if (isset($this->subclasses[$className])) {
            return $this->subclasses[$className];
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            return $this->subclasses[$className] = \false;
        }
        try {
            return $this->subclasses[$className] = $this->reflection->isSubclassOf($className);
        } catch (\ReflectionException $e) {
            return $this->subclasses[$className] = \false;
        }
    }
    public function implementsInterface(string $className) : bool
    {
        try {
            return $this->reflection->implementsInterface($className);
        } catch (\ReflectionException $e) {
            return \false;
        }
    }
    /**
     * @return \PHPStan\Reflection\ClassReflection[]
     */
    public function getParents() : array
    {
        $parents = [];
        $parent = $this->getParentClass();
        while ($parent !== \false) {
            $parents[] = $parent;
            $parent = $parent->getParentClass();
        }
        return $parents;
    }
    /**
     * @return \PHPStan\Reflection\ClassReflection[]
     */
    public function getInterfaces() : array
    {
        $interfaces = [];
        $parent = $this->getParentClass();
        if ($parent !== \false) {
            foreach ($parent->getInterfaces() as $interface) {
                $interfaces[$interface->getName()] = $interface;
            }
        }
        if ($this->reflection->isInterface()) {
            $implementsTags = $this->getExtendsTags();
        } else {
            $implementsTags = $this->getImplementsTags();
        }
        $interfaceNames = $this->reflection->getInterfaceNames();
        $genericInterfaces = [];
        foreach ($implementsTags as $implementsTag) {
            $implementedType = $implementsTag->getType();
            if (!$this->isValidAncestorType($implementedType, $interfaceNames)) {
                continue;
            }
            if ($this->isGeneric()) {
                $implementedType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($implementedType, $this->getActiveTemplateTypeMap());
            }
            if (!$implementedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
                continue;
            }
            $reflectionIface = $implementedType->getClassReflection();
            if ($reflectionIface === null) {
                continue;
            }
            $genericInterfaces[] = $reflectionIface;
        }
        foreach ($genericInterfaces as $genericInterface) {
            $interfaces = \array_merge($interfaces, $genericInterface->getInterfaces());
        }
        foreach ($genericInterfaces as $genericInterface) {
            $interfaces[$genericInterface->getName()] = $genericInterface;
        }
        foreach ($interfaceNames as $interfaceName) {
            if (isset($interfaces[$interfaceName])) {
                continue;
            }
            $interfaceReflection = $this->reflectionProvider->getClass($interfaceName);
            if (!$interfaceReflection->isGeneric()) {
                $interfaces[$interfaceName] = $interfaceReflection;
                continue;
            }
            $interfaces[$interfaceName] = $interfaceReflection->withTypes(\array_values($interfaceReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()));
        }
        return $interfaces;
    }
    /**
     * @return \PHPStan\Reflection\ClassReflection[]
     */
    public function getTraits() : array
    {
        return \array_map(function (\ReflectionClass $trait) : ClassReflection {
            return $this->reflectionProvider->getClass($trait->getName());
        }, $this->getNativeReflection()->getTraits());
    }
    /**
     * @return string[]
     */
    public function getParentClassesNames() : array
    {
        $parentNames = [];
        $currentClassReflection = $this;
        while ($currentClassReflection->getParentClass() !== \false) {
            $parentNames[] = $currentClassReflection->getParentClass()->getName();
            $currentClassReflection = $currentClassReflection->getParentClass();
        }
        return $parentNames;
    }
    public function hasConstant(string $name) : bool
    {
        if (!$this->getNativeReflection()->hasConstant($name)) {
            return \false;
        }
        $reflectionConstant = $this->getNativeReflection()->getReflectionConstant($name);
        if ($reflectionConstant === \false) {
            return \false;
        }
        return $this->reflectionProvider->hasClass($reflectionConstant->getDeclaringClass()->getName());
    }
    public function getConstant(string $name) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection
    {
        if (!isset($this->constants[$name])) {
            $reflectionConstant = $this->getNativeReflection()->getReflectionConstant($name);
            if ($reflectionConstant === \false) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MissingConstantFromReflectionException($this->getName(), $name);
            }
            $deprecatedDescription = null;
            $isDeprecated = \false;
            $isInternal = \false;
            if ($reflectionConstant->getDocComment() !== \false && $this->getFileName() !== \false) {
                $docComment = $reflectionConstant->getDocComment();
                $fileName = $this->getFileName();
                $className = $reflectionConstant->getDeclaringClass()->getName();
                $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($fileName, $className, null, null, $docComment);
                $deprecatedDescription = $resolvedPhpDoc->getDeprecatedTag() !== null ? $resolvedPhpDoc->getDeprecatedTag()->getMessage() : null;
                $isDeprecated = $resolvedPhpDoc->isDeprecated();
                $isInternal = $resolvedPhpDoc->isInternal();
            }
            $this->constants[$name] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassConstantReflection($this->reflectionProvider->getClass($reflectionConstant->getDeclaringClass()->getName()), $reflectionConstant, $deprecatedDescription, $isDeprecated, $isInternal);
        }
        return $this->constants[$name];
    }
    public function hasTraitUse(string $traitName) : bool
    {
        return \in_array($traitName, $this->getTraitNames(), \true);
    }
    /**
     * @return string[]
     */
    private function getTraitNames() : array
    {
        $class = $this->reflection;
        $traitNames = $class->getTraitNames();
        while ($class->getParentClass() !== \false) {
            $traitNames = \array_values(\array_unique(\array_merge($traitNames, $class->getParentClass()->getTraitNames())));
            $class = $class->getParentClass();
        }
        return $traitNames;
    }
    public function getDeprecatedDescription() : ?string
    {
        if ($this->deprecatedDescription === null && $this->isDeprecated()) {
            $resolvedPhpDoc = $this->getResolvedPhpDoc();
            if ($resolvedPhpDoc !== null && $resolvedPhpDoc->getDeprecatedTag() !== null) {
                $this->deprecatedDescription = $resolvedPhpDoc->getDeprecatedTag()->getMessage();
            }
        }
        return $this->deprecatedDescription;
    }
    public function isDeprecated() : bool
    {
        if ($this->isDeprecated === null) {
            $resolvedPhpDoc = $this->getResolvedPhpDoc();
            $this->isDeprecated = $resolvedPhpDoc !== null && $resolvedPhpDoc->isDeprecated();
        }
        return $this->isDeprecated;
    }
    public function isBuiltin() : bool
    {
        return $this->reflection->isInternal();
    }
    public function isInternal() : bool
    {
        if ($this->isInternal === null) {
            $resolvedPhpDoc = $this->getResolvedPhpDoc();
            $this->isInternal = $resolvedPhpDoc !== null && $resolvedPhpDoc->isInternal();
        }
        return $this->isInternal;
    }
    public function isFinal() : bool
    {
        if ($this->isFinal === null) {
            $resolvedPhpDoc = $this->getResolvedPhpDoc();
            $this->isFinal = $this->reflection->isFinal() || $resolvedPhpDoc !== null && $resolvedPhpDoc->isFinal();
        }
        return $this->isFinal;
    }
    public function isFinalByKeyword() : bool
    {
        return $this->reflection->isFinal();
    }
    public function isAttributeClass() : bool
    {
        return $this->findAttributeClass() !== null;
    }
    private function findAttributeClass() : ?\Attribute
    {
        if ($this->isInterface() || $this->isTrait()) {
            return null;
        }
        if ($this->reflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass) {
            foreach ($this->reflection->getBetterReflection()->getAttributes() as $attribute) {
                if ($attribute->getName() === \Attribute::class) {
                    /** @var \Attribute */
                    return $attribute->newInstance();
                }
            }
            return null;
        }
        if (!\method_exists($this->reflection, 'getAttributes')) {
            return null;
        }
        $nativeAttributes = $this->reflection->getAttributes(\Attribute::class);
        if (\count($nativeAttributes) === 1) {
            /** @var Attribute */
            return $nativeAttributes[0]->newInstance();
        }
        return null;
    }
    public function getAttributeClassFlags() : int
    {
        $attribute = $this->findAttributeClass();
        if ($attribute === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $attribute->flags;
    }
    public function getTemplateTypeMap() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($this->templateTypeMap !== null) {
            return $this->templateTypeMap;
        }
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            $this->templateTypeMap = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
            return $this->templateTypeMap;
        }
        $templateTypeMap = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap(\array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag $tag) : Type {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::fromTemplateTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass($this->getName()), $tag);
        }, $this->getTemplateTags()));
        $this->templateTypeMap = $templateTypeMap;
        return $templateTypeMap;
    }
    public function getActiveTemplateTypeMap() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->resolvedTemplateTypeMap ?? $this->getTemplateTypeMap();
    }
    public function isGeneric() : bool
    {
        if ($this->isGeneric === null) {
            $this->isGeneric = \count($this->getTemplateTags()) > 0;
        }
        return $this->isGeneric;
    }
    /**
     * @param array<int, Type> $types
     * @return \PHPStan\Type\Generic\TemplateTypeMap
     */
    public function typeMapFromList(array $types) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $map = [];
        $i = 0;
        foreach ($resolvedPhpDoc->getTemplateTags() as $tag) {
            $map[$tag->getName()] = $types[$i] ?? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            $i++;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap($map);
    }
    /** @return array<int, Type> */
    public function typeMapToList(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $typeMap) : array
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return [];
        }
        $list = [];
        foreach ($resolvedPhpDoc->getTemplateTags() as $tag) {
            $list[] = $typeMap->getType($tag->getName()) ?? $tag->getBound();
        }
        return $list;
    }
    /**
     * @param array<int, Type> $types
     */
    public function withTypes(array $types) : self
    {
        return new self($this->reflectionProvider, $this->fileTypeMapper, $this->phpVersion, $this->propertiesClassReflectionExtensions, $this->methodsClassReflectionExtensions, $this->displayName, $this->reflection, $this->anonymousFilename, $this->typeMapFromList($types), $this->stubPhpDocBlock);
    }
    public function getResolvedPhpDoc() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock
    {
        if ($this->stubPhpDocBlock !== null) {
            return $this->stubPhpDocBlock;
        }
        $fileName = $this->getFileName();
        if ($fileName === \false) {
            return null;
        }
        $docComment = $this->reflection->getDocComment();
        if ($docComment === \false) {
            return null;
        }
        return $this->fileTypeMapper->getResolvedPhpDoc($fileName, $this->getName(), null, null, $docComment);
    }
    private function getFirstExtendsTag() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ExtendsTag
    {
        foreach ($this->getExtendsTags() as $tag) {
            return $tag;
        }
        return null;
    }
    /** @return ExtendsTag[] */
    private function getExtendsTags() : array
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return [];
        }
        return $resolvedPhpDoc->getExtendsTags();
    }
    /** @return ImplementsTag[] */
    private function getImplementsTags() : array
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return [];
        }
        return $resolvedPhpDoc->getImplementsTags();
    }
    /** @return array<string,TemplateTag> */
    public function getTemplateTags() : array
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return [];
        }
        return $resolvedPhpDoc->getTemplateTags();
    }
    /**
     * @return array<string,ClassReflection>
     */
    public function getAncestors() : array
    {
        $ancestors = $this->ancestors;
        if ($ancestors === null) {
            $ancestors = [$this->getName() => $this];
            $addToAncestors = static function (string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection) use(&$ancestors) : void {
                if (\array_key_exists($name, $ancestors)) {
                    return;
                }
                $ancestors[$name] = $classReflection;
            };
            foreach ($this->getInterfaces() as $interface) {
                $addToAncestors($interface->getName(), $interface);
                foreach ($interface->getAncestors() as $name => $ancestor) {
                    $addToAncestors($name, $ancestor);
                }
            }
            foreach ($this->getTraits() as $trait) {
                $addToAncestors($trait->getName(), $trait);
                foreach ($trait->getAncestors() as $name => $ancestor) {
                    $addToAncestors($name, $ancestor);
                }
            }
            $parent = $this->getParentClass();
            if ($parent !== \false) {
                $addToAncestors($parent->getName(), $parent);
                foreach ($parent->getAncestors() as $name => $ancestor) {
                    $addToAncestors($name, $ancestor);
                }
            }
            $this->ancestors = $ancestors;
        }
        return $ancestors;
    }
    public function getAncestorWithClassName(string $className) : ?self
    {
        return $this->getAncestors()[$className] ?? null;
    }
    /**
     * @param string[] $ancestorClasses
     */
    private function isValidAncestorType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, array $ancestorClasses) : bool
    {
        if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
            return \false;
        }
        $reflection = $type->getClassReflection();
        if ($reflection === null) {
            return \false;
        }
        return \in_array($reflection->getName(), $ancestorClasses, \true);
    }
    /**
     * @return array<MixinTag>
     */
    public function getMixinTags() : array
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return [];
        }
        return $resolvedPhpDoc->getMixinTags();
    }
    /**
     * @return array<PropertyTag>
     */
    public function getPropertyTags() : array
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return [];
        }
        return $resolvedPhpDoc->getPropertyTags();
    }
    /**
     * @return array<MethodTag>
     */
    public function getMethodTags() : array
    {
        $resolvedPhpDoc = $this->getResolvedPhpDoc();
        if ($resolvedPhpDoc === null) {
            return [];
        }
        return $resolvedPhpDoc->getMethodTags();
    }
    /**
     * @return array<Type>
     */
    public function getResolvedMixinTypes() : array
    {
        $types = [];
        foreach ($this->getMixinTags() as $mixinTag) {
            if (!$this->isGeneric()) {
                $types[] = $mixinTag->getType();
                continue;
            }
            $types[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($mixinTag->getType(), $this->getActiveTemplateTypeMap());
        }
        return $types;
    }
}