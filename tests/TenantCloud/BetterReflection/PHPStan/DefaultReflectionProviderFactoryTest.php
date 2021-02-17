<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use Angle\Chrono;
use Nette\DI\Extensions\PhpExtension;
use PHPStan\Broker\Broker;
use PHPStan\DependencyInjection\Configurator;
use PHPStan\DependencyInjection\Container;
use PHPStan\DependencyInjection\ContainerFactory;
use PHPStan\DependencyInjection\LoaderFactory;
use PHPStan\File\FileHelper;
use PHPStan\Php\PhpVersion;
use PHPStan\Reflection\Php\PhpClassReflectionExtension;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Generic\GenericObjectType;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Cache\Cache;
use TenantCloud\BetterReflection\Cache\ReflectionCacheKeyMaster;
use TenantCloud\BetterReflection\Cache\SymfonyVarExportCacheStorage;
use TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Resolved\CachedHalfResolvedReflectionProvider;
use TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Resolved\HalfResolvedFactory;
use TenantCloud\BetterReflection\Reflection\Impl\PHPStan\Source\PHPStanSourceProvider;
use TenantCloud\TestClass;

class DefaultReflectionProviderFactoryTest extends TestCase
{
	private ReflectionProvider $reflectionProvider;

	protected function setUp(): void
	{
		parent::setUp();
	}

	public function testGenericType()
	{
		Chrono::start();

//		$currentWorkingDirectory = getcwd();
//		$fileHelper = new FileHelper($currentWorkingDirectory);
//
//		$rootDir = __DIR__ . '/../../../../vendor/phpstan/phpstan-src';
//		$rootDirectory = $fileHelper->normalizePath($rootDir);
//
//		$configurator = new Configurator(new LoaderFactory(
//			$fileHelper,
//			$rootDirectory,
//			$currentWorkingDirectory,
//			null,
//		));
//		$configurator->defaultExtensions = [
//			'php' => PhpExtension::class,
//			'extensions' => \Nette\DI\Extensions\ExtensionsExtension::class,
//		];
//		$configurator->setDebugMode(true);
//		$configurator->setTempDirectory(__DIR__ . '/tmp');
//		$configurator->addParameters([
//			'rootDir' => $rootDirectory,
//			'currentWorkingDirectory' => $currentWorkingDirectory,
//			'tmpDir' =>  __DIR__ . '/tmp',
//			'analysedPaths' => [
		////				__DIR__ . '/../../../../src',
		////				__DIR__ . '/../../../../tests',
//			],
//			'composerAutoloaderProjectPaths' => [
		////				$fileHelper->normalizePath(__DIR__ . '/../../../..')
//			],
//			'analysedPathsFromConfig' => [],
//		]);
//		$configurator->addDynamicParameters([
//			'singleReflectionFile' => null,
//		]);
//		$configurator->addConfig(__DIR__ . '/config.neon');
//
//		$container = $configurator->createContainer();
//
//		BetterReflection::$phpVersion = $container->getByType(PhpVersion::class)->getVersionId();
//
//		BetterReflection::populate(
//			$container->getService('betterReflectionSourceLocator'), // @phpstan-ignore-line
//			$container->getService('betterReflectionClassReflector'), // @phpstan-ignore-line
//			$container->getService('betterReflectionFunctionReflector'), // @phpstan-ignore-line
//			$container->getService('betterReflectionConstantReflector'), // @phpstan-ignore-line
//			$container->getService('phpParserDecorator'), // @phpstan-ignore-line
//			$container->getByType(PhpStormStubsSourceStubber::class)
//		);
//
//		/** @var Broker $broker */
//		$broker = $container->getByType(Broker::class);
//		Broker::registerInstance($broker);
//		$container->getService('typeSpecifier');
//
//		$container = $container->getByType(Container::class);

		$containerFactory = new ContainerFactory(getcwd());
		$container = $containerFactory->create(
			tempDirectory: __DIR__ . '/tmp',
			additionalConfigFiles: [__DIR__ . '/config.neon'],
			analysedPaths: [],
			usedLevel: 0,
		);

		$reflectionProvider = new CachedHalfResolvedReflectionProvider(
			new ReflectionCacheKeyMaster(),
			new Cache(
				new SymfonyVarExportCacheStorage(__DIR__ . '/tmp/half_resolved')
			),
			new HalfResolvedFactory(
				new PHPStanSourceProvider(
					$container->getByType(ReflectionProvider::class),
					$container->getByType(PhpClassReflectionExtension::class),
				)
			)
		);

		echo Chrono::meter(10);
		Chrono::start();

		$reflectionProvider->provideClass(TestClassTwo::class)->properties();

		echo Chrono::meter(10);
//		$start = microtime(true);
//
//		$type = $this->reflectionProvider
//			->getClass(TestClassTwo::class)
//			->getProperty('generic', new AllowingClassMemberAccessAnswerer())
//			->getReadableType();
//
//		var_dump(microtime(true) - $start);
//		$start = microtime(true);
//
//		$type = $this->reflectionProvider
//			->getClass(TestClass::class)
//			->getProperty('factories', new AllowingClassMemberAccessAnswerer())
//			->getReadableType();
//
//		var_dump(microtime(true) - $start);
//		$start = microtime(true);
//
//		$type = $this->reflectionProvider
//			->getClass(TestClass::class)
//			->getProperty('generic', new AllowingClassMemberAccessAnswerer())
//			->getReadableType();
//
//		var_dump(microtime(true) - $start);
//		$start = microtime(true);
//
//		$type = $this->reflectionProvider
//			->getClass(AllowingClassMemberAccessAnswerer::class)
//			->getMethod('canAccessProperty', new AllowingClassMemberAccessAnswerer())
//			->getVariants()[0]
//			->getParameters();
//
//		var_dump(microtime(true) - $start);

//		expect($type)->toBeInstanceOf(GenericObjectType::class);
//		expect($type->getTypes());
	}
}
