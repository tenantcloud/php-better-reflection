<?php

namespace TenantCloud\BetterReflection\PHPStan;

use TenantCloud\BetterReflection\Cache\Cache;
use TenantCloud\BetterReflection\Cache\ReflectionCacheKeyMaster;
use TenantCloud\BetterReflection\Cache\SymfonyVarExportCacheStorage;
use TenantCloud\BetterReflection\PHPStan\Resolved\HalfResolvedFactory;
use TenantCloud\BetterReflection\PHPStan\Source\PHPStanSourceProvider;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions\ExtensionsExtension;
use TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions\PhpExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Configurator;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\LoaderFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use function TenantCloud\Standard\Lazy\lazy;

class DefaultPHPStanReflectionProviderFactory
{
	public function __construct(private string $cacheDir, private array $additionalConfigs = [])
	{
		PHPStanReflectionProvider::bindBroker();
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

		$rootDir = __DIR__ . '/../../../../relocation/relocated/vendor/phpstan/phpstan-src';
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
			'analysedPathsFromConfig'         => [],
			'cliArgumentsVariablesRegistered' => ini_get('register_argc_argv') === '1',
			'additionalConfigFiles'           => $this->additionalConfigs,
			'generateBaselineFile'            => false,
			'usedLevel'                       => 0,
			'cliAutoloadFile'                 => null,
			'fixerTmpDir'                     => $this->cacheDir . '/phpstan-fixer',
		]);
		$configurator->addDynamicParameters([
			'singleReflectionFile' => null,
		]);
		$configurator->addConfig($rootDir . '/conf/config.neon');

		foreach ($this->additionalConfigs as $config) {
			$configurator->addConfig($config);
		}

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
