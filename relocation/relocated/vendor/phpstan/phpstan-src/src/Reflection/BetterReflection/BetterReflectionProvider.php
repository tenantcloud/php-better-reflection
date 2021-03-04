<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection;

use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Exception\InvalidIdentifierName;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionFunction;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ParamTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Constant\RuntimeConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class BetterReflectionProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector $classReflector;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector $functionReflector;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector $constantReflector;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper $anonymousClassNameHelper;
    private \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    /** @var \PHPStan\Reflection\FunctionReflection[] */
    private array $functionReflections = [];
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private array $classReflections = [];
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private static array $anonymousClasses = [];
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector $classReflector, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper $anonymousClassNameHelper, \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer, \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector $functionReflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector $constantReflector)
    {
        $this->reflectionProviderProvider = $reflectionProviderProvider;
        $this->classReflectionExtensionRegistryProvider = $classReflectionExtensionRegistryProvider;
        $this->classReflector = $classReflector;
        $this->fileTypeMapper = $fileTypeMapper;
        $this->phpVersion = $phpVersion;
        $this->nativeFunctionReflectionProvider = $nativeFunctionReflectionProvider;
        $this->stubPhpDocProvider = $stubPhpDocProvider;
        $this->functionReflectionFactory = $functionReflectionFactory;
        $this->relativePathHelper = $relativePathHelper;
        $this->anonymousClassNameHelper = $anonymousClassNameHelper;
        $this->printer = $printer;
        $this->fileHelper = $fileHelper;
        $this->functionReflector = $functionReflector;
        $this->constantReflector = $constantReflector;
    }
    public function hasClass(string $className) : bool
    {
        if (isset(self::$anonymousClasses[$className])) {
            return \true;
        }
        try {
            $this->classReflector->reflect($className);
            return \true;
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            return \false;
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
            return \false;
        }
    }
    public function getClass(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        try {
            $reflectionClass = $this->classReflector->reflect($className);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($className);
        }
        $reflectionClassName = \strtolower($reflectionClass->getName());
        if (\array_key_exists($reflectionClassName, $this->classReflections)) {
            return $this->classReflections[$reflectionClassName];
        }
        $classReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), $reflectionClass->getName(), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), null, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$reflectionClassName] = $classReflection;
        return $classReflection;
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($className);
        }
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className]->getDisplayName();
        }
        $reflectionClass = $this->classReflector->reflect($className);
        return $reflectionClass->getName();
    }
    public function supportsAnonymousClasses() : bool
    {
        return \true;
    }
    public function getAnonymousClassReflection(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $classNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        if (isset($classNode->namespacedName)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if (!$scope->isInTrait()) {
            $scopeFile = $scope->getFile();
        } else {
            $scopeFile = $scope->getTraitReflection()->getFileName();
            if ($scopeFile === \false) {
                $scopeFile = $scope->getFile();
            }
        }
        $filename = $this->fileHelper->normalizePath($this->relativePathHelper->getRelativePath($scopeFile), '/');
        $className = $this->anonymousClassNameHelper->getAnonymousClassName($classNode, $scopeFile);
        $classNode->name = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier($className);
        $classNode->setAttribute('anonymousClass', \true);
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        $reflectionClass = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass::createFromNode($this->classReflector, $classNode, new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource($this->printer->prettyPrint([$classNode]), $scopeFile), null);
        self::$anonymousClasses[$className] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), \sprintf('class@anonymous/%s:%s', $filename, $classNode->getLine()), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass($reflectionClass), $scopeFile, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
        $this->classReflections[$className] = self::$anonymousClasses[$className];
        return self::$anonymousClasses[$className];
    }
    public function hasFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveFunctionName($nameNode, $scope) !== null;
    }
    public function getFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection
    {
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if ($functionName === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
        }
        $lowerCasedFunctionName = \strtolower($functionName);
        if (isset($this->functionReflections[$lowerCasedFunctionName])) {
            return $this->functionReflections[$lowerCasedFunctionName];
        }
        $nativeFunctionReflection = $this->nativeFunctionReflectionProvider->findFunctionReflection($lowerCasedFunctionName);
        if ($nativeFunctionReflection !== null) {
            $this->functionReflections[$lowerCasedFunctionName] = $nativeFunctionReflection;
            return $nativeFunctionReflection;
        }
        $this->functionReflections[$lowerCasedFunctionName] = $this->getCustomFunction($functionName);
        return $this->functionReflections[$lowerCasedFunctionName];
    }
    private function getCustomFunction(string $functionName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpFunctionReflection
    {
        $reflectionFunction = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionFunction($this->functionReflector->reflect($functionName));
        $templateTypeMap = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $phpDocParameterTags = [];
        $phpDocReturnTag = null;
        $phpDocThrowsTag = null;
        $deprecatedTag = null;
        $isDeprecated = \false;
        $isInternal = \false;
        $isFinal = \false;
        $isPure = \false;
        $resolvedPhpDoc = $this->stubPhpDocProvider->findFunctionPhpDoc($reflectionFunction->getName());
        if ($resolvedPhpDoc === null && $reflectionFunction->getFileName() !== \false && $reflectionFunction->getDocComment() !== \false) {
            $fileName = $reflectionFunction->getFileName();
            $docComment = $reflectionFunction->getDocComment();
            $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($fileName, null, null, $reflectionFunction->getName(), $docComment);
        }
        if ($resolvedPhpDoc !== null) {
            $templateTypeMap = $resolvedPhpDoc->getTemplateTypeMap();
            $phpDocParameterTags = $resolvedPhpDoc->getParamTags();
            $phpDocReturnTag = $resolvedPhpDoc->getReturnTag();
            $phpDocThrowsTag = $resolvedPhpDoc->getThrowsTag();
            $deprecatedTag = $resolvedPhpDoc->getDeprecatedTag();
            $isDeprecated = $resolvedPhpDoc->isDeprecated();
            $isInternal = $resolvedPhpDoc->isInternal();
            $isFinal = $resolvedPhpDoc->isFinal();
            $isPure = $resolvedPhpDoc->isPure();
        }
        return $this->functionReflectionFactory->create($reflectionFunction, $templateTypeMap, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ParamTag $paramTag) : Type {
            return $paramTag->getType();
        }, $phpDocParameterTags), $phpDocReturnTag !== null ? $phpDocReturnTag->getType() : null, $phpDocThrowsTag !== null ? $phpDocThrowsTag->getType() : null, $deprecatedTag !== null ? $deprecatedTag->getMessage() : null, $isDeprecated, $isInternal, $isFinal, $reflectionFunction->getFileName(), $isPure);
    }
    public function resolveFunctionName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->functionReflector->reflect($name);
                return \true;
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Exception\InvalidIdentifierName $e) {
                // pass
            }
            return \false;
        }, $scope);
    }
    public function hasConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveConstantName($nameNode, $scope) !== null;
    }
    public function getConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection
    {
        $constantName = $this->resolveConstantName($nameNode, $scope);
        if ($constantName === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ConstantNotFoundException((string) $nameNode);
        }
        $constantReflection = $this->constantReflector->reflect($constantName);
        try {
            $constantValue = $constantReflection->getValue();
            $constantValueType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constantValue);
            $fileName = $constantReflection->getFileName();
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAClassReflection|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
            $constantValueType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
            $fileName = null;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Constant\RuntimeConstantReflection($constantName, $constantValueType, $fileName);
    }
    public function resolveConstantName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            try {
                $this->constantReflector->reflect($name);
                return \true;
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                // pass
            } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAClassReflection|\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                // pass
            }
            return \false;
        }, $scope);
    }
    /**
     * @param \PhpParser\Node\Name $nameNode
     * @param \Closure(string $name): bool $existsCallback
     * @param Scope|null $scope
     * @return string|null
     */
    private function resolveName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, \Closure $existsCallback, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        $name = (string) $nameNode;
        if ($scope !== null && $scope->getNamespace() !== null && !$nameNode->isFullyQualified()) {
            $namespacedName = \sprintf('%s\\%s', $scope->getNamespace(), $name);
            if ($existsCallback($namespacedName)) {
                return $namespacedName;
            }
        }
        if ($existsCallback($name)) {
            return $name;
        }
        return null;
    }
}
