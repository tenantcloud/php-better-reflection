<?php

namespace TenantCloud\BetterReflection\PHPStan;

use Nette\DI\Extensions\ExtensionsExtension;
use Nette\DI\Extensions\PhpExtension;
use PHPStan\BetterReflection\BetterReflection;
use PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use PHPStan\Broker\Broker;
use PHPStan\DependencyInjection\Configurator;
use PHPStan\DependencyInjection\Container;
use PHPStan\DependencyInjection\LoaderFactory;
use PHPStan\File\FileHelper;
use PHPStan\Php\PhpVersion;
use PHPStan\Reflection\Php\PhpClassReflectionExtension;
use PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Cache\Cache;
use TenantCloud\BetterReflection\Cache\ReflectionCacheKeyMaster;
use TenantCloud\BetterReflection\Cache\SymfonyVarExportCacheStorage;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedFactory;
use TenantCloud\BetterReflection\PHPStan\Source\PHPStanSourceProvider;
use function TenantCloud\Standard\Lazy\lazy;

class DefaultPHPStanReflectionProviderFactory
{
	public function __construct(private string $cacheDir)
	{
	}

	public function create(): PHPStanReflectionProvider
	{
		return new PHPStanReflectionProvider(
			new ReflectionCacheKeyMaster(),
			new Cache(
				new SymfonyVarExportCacheStorage($this->cacheDir . '/better-reflection'),
			),
			new HalfResolvedFactory(
				lazy(function () {
					$container = $this->createContainer();

					return new PHPStanSourceProvider(
						$container->getByType(ReflectionProvider::class),
						$container->getByType(PhpClassReflectionExtension::class),
					);
				})
			),
		);
	}

	private function createContainer(): Container
	{
		$currentWorkingDirectory = getcwd();
		$fileHelper = new FileHelper($currentWorkingDirectory);

		$rootDir = __DIR__ . '/../../../../vendor/phpstan/phpstan-src';
		$rootDirectory = $fileHelper->normalizePath($rootDir);

		$configurator = new Configurator(new LoaderFactory(
			$fileHelper,
			$rootDirectory,
			$currentWorkingDirectory,
			null,
		));
		$configurator->defaultExtensions = [
			'php'        => PhpExtension::class,
			'extensions' => ExtensionsExtension::class,
		];
		$configurator->setDebugMode(true);
		$configurator->setTempDirectory($this->cacheDir . '/phpstan');
		$configurator->addParameters([
			'rootDir'                 => $rootDirectory,
			'currentWorkingDirectory' => $currentWorkingDirectory,
			'tmpDir'                  => $this->cacheDir . '/phpstan',
			'analysedPaths'           => [
				//				__DIR__ . '/../../../../src',
				//				__DIR__ . '/../../../../tests',
			],
			'composerAutoloaderProjectPaths' => [
				//				$fileHelper->normalizePath(__DIR__ . '/../../../..')
			],
			'analysedPathsFromConfig' => [],
		]);
		$configurator->addDynamicParameters([
			'singleReflectionFile' => null,
		]);
		$configurator->addConfig(__DIR__ . '/config.neon');

		$container = $configurator->createContainer();

		BetterReflection::$phpVersion = $container->getByType(PhpVersion::class)->getVersionId();

		BetterReflection::populate(
			$container->getService('betterReflectionSourceLocator'), // @phpstan-ignore-line
			$container->getService('betterReflectionClassReflector'), // @phpstan-ignore-line
			$container->getService('betterReflectionFunctionReflector'), // @phpstan-ignore-line
			$container->getService('betterReflectionConstantReflector'), // @phpstan-ignore-line
			$container->getService('phpParserDecorator'), // @phpstan-ignore-line
			$container->getByType(PhpStormStubsSourceStubber::class)
		);

		/** @var Broker $broker */
		$broker = $container->getByType(Broker::class);
		Broker::registerInstance($broker);
		$container->getService('typeSpecifier');

		return $container->getByType(Container::class);
	}
}
