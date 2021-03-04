<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Testing;

use TenantCloud\BetterReflection\Relocated\Composer\Autoload\ClassLoader;
use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\DirectScopeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache;
use TenantCloud\BetterReflection\Relocated\PHPStan\Cache\MemoryCacheStorage;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\ContainerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\CachedParser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Parser\PhpParserDecorator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocNodeResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocStringResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpFunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflectionFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Runtime\RuntimeReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\SignatureMapProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
abstract class TestCase extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /** @var bool */
    public static $useStaticReflectionProvider = \false;
    /** @var array<string, Container> */
    private static array $containers = [];
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider = null;
    /** @var array{ClassReflector, FunctionReflector, ConstantReflector}|null */
    private static $reflectors;
    /** @var PhpStormStubsSourceStubber|null */
    private static $phpStormStubsSourceStubber;
    public static function getContainer() : \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container
    {
        $additionalConfigFiles = static::getAdditionalConfigFiles();
        $cacheKey = \sha1(\implode("\n", $additionalConfigFiles));
        if (!isset(self::$containers[$cacheKey])) {
            $tmpDir = \sys_get_temp_dir() . '/phpstan-tests';
            if (!@\mkdir($tmpDir, 0777) && !\is_dir($tmpDir)) {
                self::fail(\sprintf('Cannot create temp directory %s', $tmpDir));
            }
            if (self::$useStaticReflectionProvider) {
                $additionalConfigFiles[] = __DIR__ . '/TestCase-staticReflection.neon';
            }
            $rootDir = __DIR__ . '/../..';
            $containerFactory = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\ContainerFactory($rootDir);
            $container = $containerFactory->create($tmpDir, \array_merge([$containerFactory->getConfigDirectory() . '/config.level8.neon'], $additionalConfigFiles), []);
            self::$containers[$cacheKey] = $container;
            foreach ($container->getParameter('bootstrapFiles') as $bootstrapFile) {
                (static function (string $file) use($container) : void {
                    require_once $file;
                })($bootstrapFile);
            }
        }
        return self::$containers[$cacheKey];
    }
    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles() : array
    {
        return [];
    }
    public function getParser() : \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser
    {
        /** @var \PHPStan\Parser\Parser $parser */
        $parser = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\CachedParser::class);
        return $parser;
    }
    /**
     * @param \PHPStan\Type\DynamicMethodReturnTypeExtension[] $dynamicMethodReturnTypeExtensions
     * @param \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[] $dynamicStaticMethodReturnTypeExtensions
     * @return \PHPStan\Broker\Broker
     */
    public function createBroker(array $dynamicMethodReturnTypeExtensions = [], array $dynamicStaticMethodReturnTypeExtensions = []) : \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker
    {
        $dynamicReturnTypeExtensionRegistryProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider(\array_merge(self::getContainer()->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicMethodReturnTypeExtensions, $this->getDynamicMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $dynamicStaticMethodReturnTypeExtensions, $this->getDynamicStaticMethodReturnTypeExtensions()), \array_merge(self::getContainer()->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG), $this->getDynamicFunctionReturnTypeExtensions()));
        $operatorTypeSpecifyingExtensionRegistryProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider($this->getOperatorTypeSpecifyingExtensions());
        $reflectionProvider = $this->createReflectionProvider();
        $broker = new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker($reflectionProvider, $dynamicReturnTypeExtensionRegistryProvider, $operatorTypeSpecifyingExtensionRegistryProvider, self::getContainer()->getParameter('universalObjectCratesClasses'));
        $dynamicReturnTypeExtensionRegistryProvider->setBroker($broker);
        $dynamicReturnTypeExtensionRegistryProvider->setReflectionProvider($reflectionProvider);
        $operatorTypeSpecifyingExtensionRegistryProvider->setBroker($broker);
        $this->getClassReflectionExtensionRegistryProvider()->setBroker($broker);
        return $broker;
    }
    public function createReflectionProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        $staticReflectionProvider = $this->createStaticReflectionProvider();
        return $this->createReflectionProviderByParameters($this->createRuntimeReflectionProvider($staticReflectionProvider), $staticReflectionProvider, self::$useStaticReflectionProvider);
    }
    private function createReflectionProviderByParameters(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        $setterReflectionProviderProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $reflectionProviderFactory = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderFactory($runtimeReflectionProvider, $staticReflectionProvider, $disableRuntimeReflectionProvider);
        $reflectionProvider = $reflectionProviderFactory->create();
        $setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
        return $reflectionProvider;
    }
    private static function getPhpStormStubsSourceStubber() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber
    {
        if (self::$phpStormStubsSourceStubber === null) {
            self::$phpStormStubsSourceStubber = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class);
        }
        return self::$phpStormStubsSourceStubber;
    }
    private function createRuntimeReflectionProvider(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        $functionCallStatementFinder = new \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder();
        $parser = $this->getParser();
        $cache = new \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache(new \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\MemoryCacheStorage());
        $phpDocStringResolver = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper(new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($currentWorkingDirectory), new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        $reflectionProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ClassBlacklistReflectionProvider(new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Runtime\RuntimeReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionReflectionFactory, $fileTypeMapper, self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class)), self::getPhpStormStubsSourceStubber(), ['#^PhpParser\\\\#', '#^PHPStan\\\\#', '#^Hoa\\\\#'], null);
        $this->setUpReflectionProvider($actualReflectionProvider, $setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionCallStatementFinder, $parser, $cache, $fileTypeMapper);
        return $reflectionProvider;
    }
    private function setUpReflectionProvider(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $actualReflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider $setterReflectionProviderProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider $classReflectionExtensionRegistryProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper) : void
    {
        $methodReflectionFactory = new class($parser, $functionCallStatementFinder, $cache) implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflectionFactory
        {
            private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
            private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder;
            private \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache;
            public \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
            public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache)
            {
                $this->parser = $parser;
                $this->functionCallStatementFinder = $functionCallStatementFinder;
                $this->cache = $cache;
            }
            /**
             * @param ClassReflection $declaringClass
             * @param ClassReflection|null $declaringTrait
             * @param \PHPStan\Reflection\Php\BuiltinMethodReflection $reflection
             * @param TemplateTypeMap $templateTypeMap
             * @param Type[] $phpDocParameterTypes
             * @param Type|null $phpDocReturnType
             * @param Type|null $phpDocThrowType
             * @param string|null $deprecatedDescription
             * @param bool $isDeprecated
             * @param bool $isInternal
             * @param bool $isFinal
             * @param string|null $stubPhpDocString
             * @param bool|null $isPure
             * @return PhpMethodReflection
             */
            public function create(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringTrait, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?string $stubPhpDocString, ?bool $isPure = null) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection
            {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection($declaringClass, $declaringTrait, $reflection, $this->reflectionProvider, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $stubPhpDocString, $isPure);
            }
        };
        $phpDocInheritanceResolver = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
        $annotationsMethodsClassReflectionExtension = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension();
        $annotationsPropertiesClassReflectionExtension = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension();
        $signatureMapProvider = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\SignatureMapProvider::class);
        $methodReflectionFactory->reflectionProvider = $actualReflectionProvider;
        $phpExtension = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver::class), $methodReflectionFactory, $phpDocInheritanceResolver, $annotationsMethodsClassReflectionExtension, $annotationsPropertiesClassReflectionExtension, $signatureMapProvider, $parser, self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider::class), $actualReflectionProvider, $fileTypeMapper, \true, []);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension([\stdClass::class]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension());
        $classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($annotationsPropertiesClassReflectionExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($phpExtension);
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension(new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension([]));
        $classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($annotationsMethodsClassReflectionExtension);
        $setterReflectionProviderProvider->setReflectionProvider($actualReflectionProvider);
    }
    private function createStaticReflectionProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        $parser = $this->getParser();
        $phpDocStringResolver = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
        $cache = new \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache(new \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\MemoryCacheStorage());
        $fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($currentWorkingDirectory);
        $relativePathHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
        $anonymousClassNameHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, new \TenantCloud\BetterReflection\Relocated\PHPStan\File\SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
        $setterReflectionProviderProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $fileTypeMapper = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
        $functionCallStatementFinder = new \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder();
        $functionReflectionFactory = $this->getFunctionReflectionFactory($functionCallStatementFinder, $cache);
        [$classReflector, $functionReflector, $constantReflector] = self::getReflectors();
        $classReflectionExtensionRegistryProvider = $this->getClassReflectionExtensionRegistryProvider();
        $reflectionProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\BetterReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $classReflector, $fileTypeMapper, self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\StubPhpDocProvider::class), $functionReflectionFactory, $relativePathHelper, $anonymousClassNameHelper, self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard::class), $fileHelper, $functionReflector, $constantReflector);
        $this->setUpReflectionProvider($reflectionProvider, $setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $functionCallStatementFinder, $parser, $cache, $fileTypeMapper);
        return $reflectionProvider;
    }
    /**
     * @return array{ClassReflector, FunctionReflector, ConstantReflector}
     */
    public static function getReflectors() : array
    {
        if (self::$reflectors !== null) {
            return self::$reflectors;
        }
        if (!\class_exists(\TenantCloud\BetterReflection\Relocated\Composer\Autoload\ClassLoader::class)) {
            self::fail('Composer ClassLoader is unknown');
        }
        $classLoaderReflection = new \ReflectionClass(\TenantCloud\BetterReflection\Relocated\Composer\Autoload\ClassLoader::class);
        if ($classLoaderReflection->getFileName() === \false) {
            self::fail('Unknown ClassLoader filename');
        }
        $composerProjectPath = \dirname($classLoaderReflection->getFileName(), 3);
        if (!\is_file($composerProjectPath . '/composer.json')) {
            self::fail(\sprintf('composer.json not found in directory %s', $composerProjectPath));
        }
        $composerJsonAndInstalledJsonSourceLocatorMaker = self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker::class);
        $composerSourceLocator = $composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
        if ($composerSourceLocator === null) {
            self::fail('Could not create composer source locator');
        }
        // these need to be synced with TestCase-staticReflection.neon file and TestCaseSourceLocatorFactory
        $locators = [$composerSourceLocator];
        $phpParser = new \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\PhpParserDecorator(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\CachedParser::class));
        /** @var FunctionReflector $functionReflector */
        $functionReflector = null;
        $astLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator($phpParser, static function () use(&$functionReflector) : FunctionReflector {
            return $functionReflector;
        });
        $reflectionSourceStubber = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber();
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, self::getPhpStormStubsSourceStubber());
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher::class));
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $reflectionSourceStubber);
        $locators[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $reflectionSourceStubber);
        $sourceLocator = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
        $classReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector($sourceLocator);
        $functionReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector($sourceLocator, $classReflector);
        $constantReflector = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector($sourceLocator, $classReflector);
        self::$reflectors = [$classReflector, $functionReflector, $constantReflector];
        return self::$reflectors;
    }
    private function getFunctionReflectionFactory(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory
    {
        return new class($this->getParser(), $functionCallStatementFinder, $cache) implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflectionFactory
        {
            private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
            private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder;
            private \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache;
            public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\FunctionCallStatementFinder $functionCallStatementFinder, \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\Cache $cache)
            {
                $this->parser = $parser;
                $this->functionCallStatementFinder = $functionCallStatementFinder;
                $this->cache = $cache;
            }
            /**
             * @param \ReflectionFunction $function
             * @param TemplateTypeMap $templateTypeMap
             * @param Type[] $phpDocParameterTypes
             * @param Type|null $phpDocReturnType
             * @param Type|null $phpDocThrowType
             * @param string|null $deprecatedDescription
             * @param bool $isDeprecated
             * @param bool $isInternal
             * @param bool $isFinal
             * @param string|false $filename
             * @param bool|null $isPure
             * @return PhpFunctionReflection
             */
            public function create(\ReflectionFunction $function, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $phpDocParameterTypes, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocThrowType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, $filename, ?bool $isPure = null) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpFunctionReflection
            {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpFunctionReflection($function, $this->parser, $this->functionCallStatementFinder, $this->cache, $templateTypeMap, $phpDocParameterTypes, $phpDocReturnType, $phpDocThrowType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal, $filename, $isPure);
            }
        };
    }
    public function getClassReflectionExtensionRegistryProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider
    {
        if ($this->classReflectionExtensionRegistryProvider === null) {
            $this->classReflectionExtensionRegistryProvider = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider([], []);
        }
        return $this->classReflectionExtensionRegistryProvider;
    }
    public function createScopeFactory(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker $broker, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory
    {
        $container = self::getContainer();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\DirectScopeFactory(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope::class, $broker, $broker->getDynamicReturnTypeExtensionRegistryProvider(), $broker->getOperatorTypeSpecifyingExtensionRegistryProvider(), new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard(), $typeSpecifier, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder(), $this->getParser(), self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver::class), $this->shouldTreatPhpDocTypesAsCertain(), \false, $container);
    }
    protected function shouldTreatPhpDocTypesAsCertain() : bool
    {
        return \true;
    }
    public function getCurrentWorkingDirectory() : string
    {
        return $this->getFileHelper()->normalizePath(__DIR__ . '/../..');
    }
    /**
     * @return \PHPStan\Type\DynamicMethodReturnTypeExtension[]
     */
    public function getDynamicMethodReturnTypeExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[]
     */
    public function getDynamicStaticMethodReturnTypeExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\DynamicFunctionReturnTypeExtension[]
     */
    public function getDynamicFunctionReturnTypeExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\OperatorTypeSpecifyingExtension[]
     */
    public function getOperatorTypeSpecifyingExtensions() : array
    {
        return [];
    }
    /**
     * @param \PhpParser\PrettyPrinter\Standard $printer
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\Type\MethodTypeSpecifyingExtension[] $methodTypeSpecifyingExtensions
     * @param \PHPStan\Type\StaticMethodTypeSpecifyingExtension[] $staticMethodTypeSpecifyingExtensions
     * @return \PHPStan\Analyser\TypeSpecifier
     */
    public function createTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $methodTypeSpecifyingExtensions = [], array $staticMethodTypeSpecifyingExtensions = []) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier($printer, $reflectionProvider, self::getContainer()->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG), \array_merge($methodTypeSpecifyingExtensions, self::getContainer()->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory::METHOD_TYPE_SPECIFYING_EXTENSION_TAG)), \array_merge($staticMethodTypeSpecifyingExtensions, self::getContainer()->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierFactory::STATIC_METHOD_TYPE_SPECIFYING_EXTENSION_TAG)));
    }
    public function getFileHelper() : \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper
    {
        return self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper::class);
    }
    /**
     * Provides a DIRECTORY_SEPARATOR agnostic assertion helper, to compare file paths.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    protected function assertSamePaths(string $expected, string $actual, string $message = '') : void
    {
        $expected = $this->getFileHelper()->normalizePath($expected);
        $actual = $this->getFileHelper()->normalizePath($actual);
        $this->assertSame($expected, $actual, $message);
    }
    protected function skipIfNotOnWindows() : void
    {
        if (\DIRECTORY_SEPARATOR === '\\') {
            return;
        }
        self::markTestSkipped();
    }
    protected function skipIfNotOnUnix() : void
    {
        if (\DIRECTORY_SEPARATOR === '/') {
            return;
        }
        self::markTestSkipped();
    }
}
