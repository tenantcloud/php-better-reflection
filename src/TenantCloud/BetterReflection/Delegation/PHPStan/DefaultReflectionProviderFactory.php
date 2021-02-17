<?php

namespace TenantCloud\BetterReflection\Delegation\PHPStan;

use Composer\Autoload\ClassLoader;
use LogicException;
use Nette\DI\Container;
use PhpParser\Lexer\Emulative;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitor\NodeConnectingVisitor;
use PhpParser\Parser\Php7;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\LazyScopeFactory;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Analyser\NodeScopeResolver;
use PHPStan\Analyser\TypeSpecifierFactory;
use PHPStan\Broker\AnonymousClassNameHelper;
use PHPStan\Cache\Cache;
use PHPStan\Cache\MemoryCacheStorage;
use PHPStan\DependencyInjection\ContainerFactory;
use PHPStan\DependencyInjection\MemoizingContainer;
use PHPStan\DependencyInjection\Nette\NetteContainer;
use PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use PHPStan\File\FileExcluder;
use PHPStan\File\FileExcluderFactory;
use PHPStan\File\FileExcluderRawFactory;
use PHPStan\File\FileFinder;
use PHPStan\File\FileHelper;
use PHPStan\File\SimpleRelativePathHelper;
use PHPStan\NodeVisitor\StatementOrderVisitor;
use PHPStan\Parser\CachedParser;
use PHPStan\Parser\FunctionCallStatementFinder;
use PHPStan\Parser\LexerFactory;
use PHPStan\Parser\Parser;
use PHPStan\Parser\PathRoutingParser;
use PHPStan\Parser\PhpParserDecorator;
use PHPStan\Parser\RichParser;
use PHPStan\Parser\SimpleParser;
use PHPStan\Php\PhpVersionFactory;
use PHPStan\PhpDoc\ConstExprNodeResolver;
use PHPStan\PhpDoc\LazyTypeNodeResolverExtensionRegistryProvider;
use PHPStan\PhpDoc\PhpDocInheritanceResolver;
use PHPStan\PhpDoc\PhpDocNodeResolver;
use PHPStan\PhpDoc\PhpDocStringResolver;
use PHPStan\PhpDoc\StubPhpDocProvider;
use PHPStan\PhpDoc\TypeNodeResolver;
use PHPStan\PhpDoc\TypeStringResolver;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\ConstExprParser;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TypeParser;
use PHPStan\Reflection\Annotations\AnnotationsMethodsClassReflectionExtension;
use PHPStan\Reflection\Annotations\AnnotationsPropertiesClassReflectionExtension;
use PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
use PHPStan\Reflection\BetterReflection\Reflector\MemoizingClassReflector;
use PHPStan\Reflection\BetterReflection\Reflector\MemoizingConstantReflector;
use PHPStan\Reflection\BetterReflection\Reflector\MemoizingFunctionReflector;
use PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use PHPStan\Reflection\BetterReflection\SourceLocator\CachingVisitor;
use PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedPsrAutoloaderLocator;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedPsrAutoloaderLocatorFactory;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocator;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorFactory;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionReflectionFactory;
use PHPStan\Reflection\Mixin\MixinMethodsClassReflectionExtension;
use PHPStan\Reflection\Mixin\MixinPropertiesClassReflectionExtension;
use PHPStan\Reflection\Php\BuiltinMethodReflection;
use PHPStan\Reflection\Php\PhpClassReflectionExtension;
use PHPStan\Reflection\Php\PhpFunctionReflection;
use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\Reflection\Php\PhpMethodReflectionFactory;
use PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Reflection\SignatureMap\FunctionSignatureMapProvider;
use PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use PHPStan\Reflection\SignatureMap\Php8SignatureMapProvider;
use PHPStan\Reflection\SignatureMap\SignatureMapParser;
use PHPStan\Reflection\SignatureMap\SignatureMapProviderFactory;
use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Php\SimpleXMLElementClassPropertyReflectionExtension;
use PHPStan\Type\Type;
use ReflectionClass;
use ReflectionFunction;
use Roave\BetterReflection\Reflector\FunctionReflector;
use Roave\BetterReflection\SourceLocator\Ast\Locator;
use Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping;
use Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use stdClass;

class DefaultReflectionProviderFactory
{
	public function create(string $cachePath, array $paths): ReflectionProvider
	{
		$containerFactory = new ContainerFactory(getcwd());

		$container = $containerFactory->create(
			tempDirectory: $cachePath,
			additionalConfigFiles: [__DIR__ . '/config.neon'],
			analysedPaths: $paths,
			usedLevel: 0,
		);

		return $container->getByType(ReflectionProvider::class);
	}

//	public function create(string $cachePath, array $paths): ReflectionProvider
//	{
//		$fileHelper = new FileHelper(__DIR__);
//		$currentWorkingDirectory = $fileHelper->normalizePath(__DIR__ . '/../../../../..');
//		$phpVersion = (new PhpVersionFactory(null, null))->create();
//		$currentLexer = (new LexerFactory($phpVersion))->create();
//		$parser = new CachedParser(
//			new PathRoutingParser(
//				$fileHelper,
//				new RichParser(
//					new Php7($currentLexer),
//					new NameResolver(),
//					new NodeConnectingVisitor(),
//					new StatementOrderVisitor()
//				),
//				new SimpleParser(
//					new Php7($currentLexer),
//					new NameResolver(),
//				),
//				new SimpleParser(
//					$php8Parser = new Php7(
//						new Emulative()
//					),
//					new NameResolver(),
//				)
//			),
//			1024
//		);
//		$phpDocStringResolver = new PhpDocStringResolver(
//			new Lexer(),
//			new PhpDocParser(
//				new TypeParser(),
//				new ConstExprParser(),
//			),
//		);
//		$netteContainer = new Container([
//			'dynamicConstantNames' => [
//				ICONV_IMPL,
//				LIBXML_VERSION,
//				LIBXML_DOTTED_VERSION,
//				PHP_VERSION,
//				PHP_MAJOR_VERSION,
//				PHP_MINOR_VERSION,
//				PHP_RELEASE_VERSION,
//				PHP_VERSION_ID,
//				PHP_EXTRA_VERSION,
//				PHP_ZTS,
//				PHP_DEBUG,
//				PHP_MAXPATHLEN,
//				PHP_OS,
//				PHP_OS_FAMILY,
//				PHP_SAPI,
//				PHP_EOL,
//				PHP_INT_MAX,
//				PHP_INT_MIN,
//				PHP_INT_SIZE,
//				PHP_FLOAT_DIG,
//				PHP_FLOAT_EPSILON,
//				PHP_FLOAT_MIN,
//				PHP_FLOAT_MAX,
//				DEFAULT_INCLUDE_PATH,
//				PEAR_INSTALL_DIR,
//				PEAR_EXTENSION_DIR,
//				PHP_EXTENSION_DIR,
//				PHP_PREFIX,
//				PHP_BINDIR,
//				PHP_BINARY,
//				PHP_MANDIR,
//				PHP_LIBDIR,
//				PHP_DATADIR,
//				PHP_SYSCONFDIR,
//				PHP_LOCALSTATEDIR,
//				PHP_CONFIG_FILE_PATH,
//				PHP_CONFIG_FILE_SCAN_DIR,
//				PHP_SHLIB_SUFFIX,
//				PHP_FD_SETSIZE,
//				OPENSSL_VERSION_NUMBER,
//			],
//			'treatPhpDocTypesAsCertain' => true,
//		]);
//
//		$container = new MemoizingContainer(
//			new NetteContainer($netteContainer)
//		);
//		$phpDocNodeResolver = new PhpDocNodeResolver(
//			$typeNodeResolver = new TypeNodeResolver(
//				new LazyTypeNodeResolverExtensionRegistryProvider($container),
//				$container
//			),
//			new ConstExprNodeResolver(),
//		);
//		$cache = new Cache(new MemoryCacheStorage());
//		$fileHelper = new FileHelper($currentWorkingDirectory);
//		$relativePathHelper = new SimpleRelativePathHelper($currentWorkingDirectory);
//		$anonymousClassNameHelper = new AnonymousClassNameHelper($fileHelper, new SimpleRelativePathHelper($fileHelper->normalizePath($currentWorkingDirectory, '/')));
//		$setterReflectionProviderProvider = new ReflectionProvider\SetterReflectionProviderProvider();
//		$fileTypeMapper = new FileTypeMapper($setterReflectionProviderProvider, $parser, $phpDocStringResolver, $phpDocNodeResolver, $cache, $anonymousClassNameHelper);
//		$functionCallStatementFinder = new FunctionCallStatementFinder();
//		$functionReflectionFactory = $this->getFunctionReflectionFactory(
//			$parser,
//			$functionCallStatementFinder,
//			$cache
//		);
//
//		[$classReflector, $functionReflector, $constantReflector] = $this->getReflectors($parser, $php8Parser, $fileHelper);
//
//		$classReflectionExtensionRegistryProvider = new DirectClassReflectionExtensionRegistryProvider([], []);
//		$signatureMapProvider = (new SignatureMapProviderFactory(
//			$phpVersion,
//			$functionsSignatureMapProvider = new FunctionSignatureMapProvider(
//				new SignatureMapParser(
//					new TypeStringResolver(
//						new Lexer(),
//						new TypeParser(),
//						$typeNodeResolver
//					),
//				),
//				$phpVersion
//			),
//			new Php8SignatureMapProvider(
//				$functionsSignatureMapProvider,
//				new FileNodesFetcher(new CachingVisitor(), $parser),
//				$fileTypeMapper
//			)
//		))->create();
//
//		$reflectionProvider = new BetterReflectionProvider(
//			$setterReflectionProviderProvider,
//			$classReflectionExtensionRegistryProvider,
//			$classReflector,
//			$fileTypeMapper,
//			$phpVersion,
//			new NativeFunctionReflectionProvider($signatureMapProvider),
//			$stubPhpDocProvider = new StubPhpDocProvider($parser, $fileTypeMapper, []),
//			$functionReflectionFactory,
//			$relativePathHelper,
//			$anonymousClassNameHelper,
//			new Standard,
//			$fileHelper,
//			$functionReflector,
//			$constantReflector
//		);
//
//		$netteContainer->addService(TypeNodeResolver::class, $typeNodeResolver);
//		$netteContainer->addService(ReflectionProvider::class, $reflectionProvider);
//
//		$methodReflectionFactory = $this->getMethodReflectionFactory(
//			$functionCallStatementFinder,
//			$parser,
//			$cache,
//		);
//		$phpDocInheritanceResolver = new PhpDocInheritanceResolver($fileTypeMapper);
//		$annotationsMethodsClassReflectionExtension = new AnnotationsMethodsClassReflectionExtension();
//		$annotationsPropertiesClassReflectionExtension = new AnnotationsPropertiesClassReflectionExtension();
//		$methodReflectionFactory->reflectionProvider = $reflectionProvider;
//		$scopeFactory = new LazyScopeFactory(MutatingScope::class, $container);
//		$nodeScopeResolver = new NodeScopeResolver(
//			$reflectionProvider,
//			$classReflector,
//			$classReflectionExtensionRegistryProvider,
//			$parser,
//			$fileTypeMapper,
//			$phpVersion,
//			$phpDocInheritanceResolver,
//			$fileHelper,
//			(new TypeSpecifierFactory($container))->create(),
//			polluteScopeWithLoopInitialAssignments: true,
//			polluteCatchScopeWithTryAssignments: false,
//			polluteScopeWithAlwaysIterableForeach: true,
//			earlyTerminatingMethodCalls: [],
//			earlyTerminatingFunctionCalls: []
//		);
//		$phpExtension = new PhpClassReflectionExtension(
//			$scopeFactory,
//			$nodeScopeResolver,
//			$methodReflectionFactory,
//			$phpDocInheritanceResolver,
//			$annotationsMethodsClassReflectionExtension,
//			$annotationsPropertiesClassReflectionExtension,
//			$signatureMapProvider,
//			$parser,
//			$stubPhpDocProvider,
//			$reflectionProvider,
//			$fileTypeMapper,
//			true,
//			[]
//		);
//		$classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($phpExtension);
//		$classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new UniversalObjectCratesClassReflectionExtension([stdClass::class]));
//		$classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new MixinPropertiesClassReflectionExtension([]));
//		$classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension(new SimpleXMLElementClassPropertyReflectionExtension());
//		$classReflectionExtensionRegistryProvider->addPropertiesClassReflectionExtension($annotationsPropertiesClassReflectionExtension);
//		$classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($phpExtension);
//		$classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension(new MixinMethodsClassReflectionExtension([]));
//		$classReflectionExtensionRegistryProvider->addMethodsClassReflectionExtension($annotationsMethodsClassReflectionExtension);
//
//		$setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
//	}
//
//	private function getMethodReflectionFactory(
//		FunctionCallStatementFinder $functionCallStatementFinder,
//		Parser $parser,
//		Cache $cache,
//	): PhpMethodReflectionFactory {
//		return new class($parser, $functionCallStatementFinder, $cache) implements PhpMethodReflectionFactory {
//			private Parser $parser;
//
//			private FunctionCallStatementFinder $functionCallStatementFinder;
//
//			private Cache $cache;
//
//			public ReflectionProvider $reflectionProvider;
//
//			public function __construct(
//				Parser $parser,
//				FunctionCallStatementFinder $functionCallStatementFinder,
//				Cache $cache
//			)
//			{
//				$this->parser = $parser;
//				$this->functionCallStatementFinder = $functionCallStatementFinder;
//				$this->cache = $cache;
//			}
//
//			/**
//			 * @param Type[] $phpDocParameterTypes
//			 */
//			public function create(
//				ClassReflection $declaringClass,
//				?ClassReflection $declaringTrait,
//				BuiltinMethodReflection $reflection,
//				TemplateTypeMap $templateTypeMap,
//				array $phpDocParameterTypes,
//				?Type $phpDocReturnType,
//				?Type $phpDocThrowType,
//				?string $deprecatedDescription,
//				bool $isDeprecated,
//				bool $isInternal,
//				bool $isFinal,
//				?string $stubPhpDocString,
//				?bool $isPure = null
//			): PhpMethodReflection
//			{
//				return new PhpMethodReflection(
//					$declaringClass,
//					$declaringTrait,
//					$reflection,
//					$this->reflectionProvider,
//					$this->parser,
//					$this->functionCallStatementFinder,
//					$this->cache,
//					$templateTypeMap,
//					$phpDocParameterTypes,
//					$phpDocReturnType,
//					$phpDocThrowType,
//					$deprecatedDescription,
//					$isDeprecated,
//					$isInternal,
//					$isFinal,
//					$stubPhpDocString,
//					$isPure
//				);
//			}
//
//		};
//	}
//
//	private function getFunctionReflectionFactory(Parser $parser, FunctionCallStatementFinder $functionCallStatementFinder, Cache $cache): FunctionReflectionFactory {
//		return new class($parser, $functionCallStatementFinder, $cache) implements FunctionReflectionFactory {
//			public function __construct(
//				private Parser $parser,
//				private FunctionCallStatementFinder $functionCallStatementFinder,
//				private Cache $cache
//			) {}
//
//			/**
//			 * @param Type[] $phpDocParameterTypes
//			 * @param string|false $filename
//			 */
//			public function create(
//				ReflectionFunction $function,
//				TemplateTypeMap $templateTypeMap,
//				array $phpDocParameterTypes,
//				?Type $phpDocReturnType,
//				?Type $phpDocThrowType,
//				?string $deprecatedDescription,
//				bool $isDeprecated,
//				bool $isInternal,
//				bool $isFinal,
//				$filename,
//				?bool $isPure = null
//			): PhpFunctionReflection {
//				return new PhpFunctionReflection(
//					$function,
//					$this->parser,
//					$this->functionCallStatementFinder,
//					$this->cache,
//					$templateTypeMap,
//					$phpDocParameterTypes,
//					$phpDocReturnType,
//					$phpDocThrowType,
//					$deprecatedDescription,
//					$isDeprecated,
//					$isInternal,
//					$isFinal,
//					$filename,
//					$isPure
//				);
//			}
//
//		};
//	}
//
//	/**
//	 * @return array{ClassReflector, FunctionReflector, ConstantReflector}
//	 */
//	public function getReflectors(Parser $parser, \PhpParser\Parser $php8PhpParser, FileHelper $fileHelper): array
//	{
//		if (!class_exists(ClassLoader::class)) {
//			throw new LogicException('Composer ClassLoader is unknown');
//		}
//
//		$classLoaderReflection = new ReflectionClass(ClassLoader::class);
//		if ($classLoaderReflection->getFileName() === false) {
//			throw new LogicException('Unknown ClassLoader filename');
//		}
//
//		$composerProjectPath = dirname($classLoaderReflection->getFileName(), 3);
//		if (!is_file($composerProjectPath . '/composer.json')) {
//			throw new LogicException(sprintf('composer.json not found in directory %s', $composerProjectPath));
//		}
//
//		$fileNodesFetcher = new FileNodesFetcher(new CachingVisitor(), $parser);
//		$optimizedDirectorySourceLocatorFactory = new OptimizedDirectorySourceLocatorFactory(
//			$fileNodesFetcher,
//			new FileFinder(
//				(new FileExcluderFactory(
//					new class ($fileHelper) implements FileExcluderRawFactory {
//						public function __construct(private FileHelper $fileHelper)
//						{
//						}
//
//						public function create(array $analyseExcludes): FileExcluder
//						{
//							return new FileExcluder($this->fileHelper, [], []);
//						}
//					},
//					[],
//					null
//				))->createScanFileExcluder(),
//				$fileHelper,
//				['php']
//			)
//		);
//		$optimizedSingleFileSourceLocatorRepository = new OptimizedSingleFileSourceLocatorRepository(
//			new class ($fileNodesFetcher) implements OptimizedSingleFileSourceLocatorFactory {
//				public function __construct(private FileNodesFetcher $fileNodesFetcher)
//				{
//				}
//
//				public function create(string $fileName): OptimizedSingleFileSourceLocator
//				{
//					return new OptimizedSingleFileSourceLocator($this->fileNodesFetcher, $fileName);
//				}
//			}
//		);
//		$composerJsonAndInstalledJsonSourceLocatorMaker = new ComposerJsonAndInstalledJsonSourceLocatorMaker(
//			new OptimizedDirectorySourceLocatorRepository($optimizedDirectorySourceLocatorFactory),
//			new class ($optimizedSingleFileSourceLocatorRepository) implements OptimizedPsrAutoloaderLocatorFactory {
//				public function __construct(private OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository)
//				{
//				}
//
//				public function create(PsrAutoloaderMapping $mapping): OptimizedPsrAutoloaderLocator
//				{
//					return new OptimizedPsrAutoloaderLocator($mapping, $this->optimizedSingleFileSourceLocatorRepository);
//				}
//			},
//			$optimizedDirectorySourceLocatorFactory,
//		);
//		$composerSourceLocator = $composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
//		if ($composerSourceLocator === null) {
//			throw new LogicException('Could not create composer source locator');
//		}
//
//		// these need to be synced with TestCase-staticReflection.neon file and TestCaseSourceLocatorFactory
//
//		$locators = [
//			$composerSourceLocator,
//		];
//
//		$phpParser = new PhpParserDecorator($parser);
//
//		/** @var FunctionReflector $functionReflector */
//		$functionReflector = null;
//		$astLocator = new Locator($phpParser, static function () use (&$functionReflector): FunctionReflector {
//			return $functionReflector;
//		});
//		$reflectionSourceStubber = new ReflectionSourceStubber();
//		$locators[] = new PhpInternalSourceLocator($astLocator, new PhpStormStubsSourceStubber($php8PhpParser));
//		$locators[] = new AutoloadSourceLocator($fileNodesFetcher);
//		$locators[] = new PhpInternalSourceLocator($astLocator, $reflectionSourceStubber);
//		$locators[] = new EvaledCodeSourceLocator($astLocator, $reflectionSourceStubber);
//		$sourceLocator = new MemoizingSourceLocator(new AggregateSourceLocator($locators));
//
//		$classReflector = new MemoizingClassReflector($sourceLocator);
//		$functionReflector = new MemoizingFunctionReflector($sourceLocator, $classReflector);
//		$constantReflector = new MemoizingConstantReflector($sourceLocator, $classReflector);
//
//		return [$classReflector, $functionReflector, $constantReflector];
//	}
}
