<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Runtime;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ParamTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Constant\RuntimeConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use ReflectionClass;
class RuntimeReflectionProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider;
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private array $classReflections = [];
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber;
    /** @var \PHPStan\Reflection\FunctionReflection[] */
    private array $functionReflections = [];
    /** @var \PHPStan\Reflection\Php\PhpFunctionReflection[] */
    private array $customFunctionReflections = [];
    /** @var bool[] */
    private array $hasClassCache = [];
    /** @var \PHPStan\Reflection\ClassReflection[] */
    private static array $anonymousClasses = [];
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider $reflectionProviderProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory $functionReflectionFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider $nativeFunctionReflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider $stubPhpDocProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber)
    {
        $this->reflectionProviderProvider = $reflectionProviderProvider;
        $this->classReflectionExtensionRegistryProvider = $classReflectionExtensionRegistryProvider;
        $this->functionReflectionFactory = $functionReflectionFactory;
        $this->fileTypeMapper = $fileTypeMapper;
        $this->phpVersion = $phpVersion;
        $this->nativeFunctionReflectionProvider = $nativeFunctionReflectionProvider;
        $this->stubPhpDocProvider = $stubPhpDocProvider;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
    }
    public function getClass(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        /** @var class-string $className */
        $className = $className;
        if (!$this->hasClass($className)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($className);
        }
        if (isset(self::$anonymousClasses[$className])) {
            return self::$anonymousClasses[$className];
        }
        if (!isset($this->classReflections[$className])) {
            $reflectionClass = new \ReflectionClass($className);
            $filename = null;
            if ($reflectionClass->getFileName() !== \false) {
                $filename = $reflectionClass->getFileName();
            }
            $classReflection = $this->getClassFromReflection($reflectionClass, $reflectionClass->getName(), $reflectionClass->isAnonymous() ? $filename : null);
            $this->classReflections[$className] = $classReflection;
            if ($className !== $reflectionClass->getName()) {
                // class alias optimization
                $this->classReflections[$reflectionClass->getName()] = $classReflection;
            }
        }
        return $this->classReflections[$className];
    }
    public function getClassName(string $className) : string
    {
        if (!$this->hasClass($className)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($className);
        }
        /** @var class-string $className */
        $className = $className;
        $reflectionClass = new \ReflectionClass($className);
        $realName = $reflectionClass->getName();
        if (isset(self::$anonymousClasses[$realName])) {
            return self::$anonymousClasses[$realName]->getDisplayName();
        }
        return $realName;
    }
    public function supportsAnonymousClasses() : bool
    {
        return \false;
    }
    public function getAnonymousClassReflection(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $classNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    /**
     * @param \ReflectionClass<object> $reflectionClass
     * @param string $displayName
     * @param string|null $anonymousFilename
     */
    private function getClassFromReflection(\ReflectionClass $reflectionClass, string $displayName, ?string $anonymousFilename) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        $className = $reflectionClass->getName();
        if (!isset($this->classReflections[$className])) {
            $classReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection($this->reflectionProviderProvider->getReflectionProvider(), $this->fileTypeMapper, $this->phpVersion, $this->classReflectionExtensionRegistryProvider->getRegistry()->getPropertiesClassReflectionExtensions(), $this->classReflectionExtensionRegistryProvider->getRegistry()->getMethodsClassReflectionExtensions(), $displayName, $reflectionClass, $anonymousFilename, null, $this->stubPhpDocProvider->findClassPhpDoc($className));
            $this->classReflections[$className] = $classReflection;
        }
        return $this->classReflections[$className];
    }
    public function hasClass(string $className) : bool
    {
        $className = \trim($className, '\\');
        if (isset($this->hasClassCache[$className])) {
            return $this->hasClassCache[$className];
        }
        \spl_autoload_register($autoloader = function (string $autoloadedClassName) use($className) : void {
            $autoloadedClassName = \trim($autoloadedClassName, '\\');
            if ($autoloadedClassName !== $className && !$this->isExistsCheckCall()) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassAutoloadingException($autoloadedClassName);
            }
        });
        try {
            return $this->hasClassCache[$className] = \class_exists($className) || \interface_exists($className) || \trait_exists($className);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassAutoloadingException $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassAutoloadingException($className, $t);
        } finally {
            \spl_autoload_unregister($autoloader);
        }
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
        $this->functionReflections[$lowerCasedFunctionName] = $this->getCustomFunction($nameNode, $scope);
        return $this->functionReflections[$lowerCasedFunctionName];
    }
    public function hasFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->resolveFunctionName($nameNode, $scope) !== null;
    }
    private function hasCustomFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if ($functionName === null) {
            return \false;
        }
        return $this->nativeFunctionReflectionProvider->findFunctionReflection($functionName) === null;
    }
    private function getCustomFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpFunctionReflection
    {
        if (!$this->hasCustomFunction($nameNode, $scope)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
        }
        /** @var string $functionName */
        $functionName = $this->resolveFunctionName($nameNode, $scope);
        if (!\function_exists($functionName)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\FunctionNotFoundException($functionName);
        }
        $lowerCasedFunctionName = \strtolower($functionName);
        if (isset($this->customFunctionReflections[$lowerCasedFunctionName])) {
            return $this->customFunctionReflections[$lowerCasedFunctionName];
        }
        $reflectionFunction = new \ReflectionFunction($functionName);
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
        $functionReflection = $this->functionReflectionFactory->create($reflectionFunction, $templateTypeMap, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ParamTag $paramTag) : Type {
            return $paramTag->getType();
        }, $phpDocParameterTags), $phpDocReturnTag !== null ? $phpDocReturnTag->getType() : null, $phpDocThrowsTag !== null ? $phpDocThrowsTag->getType() : null, $deprecatedTag !== null ? $deprecatedTag->getMessage() : null, $isDeprecated, $isInternal, $isFinal, $reflectionFunction->getFileName(), $isPure);
        $this->customFunctionReflections[$lowerCasedFunctionName] = $functionReflection;
        return $functionReflection;
    }
    public function resolveFunctionName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, function (string $name) : bool {
            $exists = \function_exists($name);
            if ($exists) {
                if ($this->phpStormStubsSourceStubber->isPresentFunction($name) === \false) {
                    return \false;
                }
                return \true;
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
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Constant\RuntimeConstantReflection($constantName, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\constant($constantName)), null);
    }
    public function resolveConstantName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->resolveName($nameNode, static function (string $name) : bool {
            return \defined($name);
        }, $scope);
    }
    /**
     * @param Node\Name $nameNode
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
    private function isExistsCheckCall() : bool
    {
        $debugBacktrace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS);
        $existsCallTypes = ['class_exists' => \true, 'interface_exists' => \true, 'trait_exists' => \true];
        foreach ($debugBacktrace as $traceStep) {
            if (isset($traceStep['function']) && isset($existsCallTypes[$traceStep['function']]) && (!isset($traceStep['file']) || $traceStep['file'] !== __FILE__)) {
                return \true;
            }
        }
        return \false;
    }
}
