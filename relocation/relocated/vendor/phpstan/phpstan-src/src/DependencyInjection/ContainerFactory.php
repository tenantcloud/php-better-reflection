<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions\PhpExtension;
use Phar;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Command\CommandHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Finder;
use function sys_get_temp_dir;
class ContainerFactory
{
    private string $currentWorkingDirectory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    private string $rootDirectory;
    private string $configDirectory;
    public function __construct(string $currentWorkingDirectory)
    {
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->fileHelper = new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper($currentWorkingDirectory);
        $rootDir = __DIR__ . '/../..';
        $originalRootDir = $this->fileHelper->normalizePath($rootDir);
        if (\extension_loaded('phar')) {
            $pharPath = \Phar::running(\false);
            if ($pharPath !== '') {
                $rootDir = \dirname($pharPath);
            }
        }
        $this->rootDirectory = $this->fileHelper->normalizePath($rootDir);
        $this->configDirectory = $originalRootDir . '/conf';
    }
    /**
     * @param string $tempDirectory
     * @param string[] $additionalConfigFiles
     * @param string[] $analysedPaths
     * @param string[] $composerAutoloaderProjectPaths
     * @param string[] $analysedPathsFromConfig
     * @param string $usedLevel
     * @param string|null $generateBaselineFile
     * @param string|null $cliAutoloadFile
     * @param string|null $singleReflectionFile
     * @return \PHPStan\DependencyInjection\Container
     */
    public function create(string $tempDirectory, array $additionalConfigFiles, array $analysedPaths, array $composerAutoloaderProjectPaths = [], array $analysedPathsFromConfig = [], string $usedLevel = \TenantCloud\BetterReflection\Relocated\PHPStan\Command\CommandHelper::DEFAULT_LEVEL, ?string $generateBaselineFile = null, ?string $cliAutoloadFile = null, ?string $singleReflectionFile = null) : \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container
    {
        $configurator = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Configurator(new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\LoaderFactory($this->fileHelper, $this->rootDirectory, $this->currentWorkingDirectory, $generateBaselineFile));
        $configurator->defaultExtensions = ['php' => \TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions\PhpExtension::class, 'extensions' => \TenantCloud\BetterReflection\Relocated\Nette\DI\Extensions\ExtensionsExtension::class];
        $configurator->setDebugMode(\true);
        $configurator->setTempDirectory($tempDirectory);
        $configurator->addParameters(['rootDir' => $this->rootDirectory, 'currentWorkingDirectory' => $this->currentWorkingDirectory, 'cliArgumentsVariablesRegistered' => \ini_get('register_argc_argv') === '1', 'tmpDir' => $tempDirectory, 'additionalConfigFiles' => $additionalConfigFiles, 'analysedPaths' => $analysedPaths, 'composerAutoloaderProjectPaths' => $composerAutoloaderProjectPaths, 'analysedPathsFromConfig' => $analysedPathsFromConfig, 'generateBaselineFile' => $generateBaselineFile, 'usedLevel' => $usedLevel, 'cliAutoloadFile' => $cliAutoloadFile, 'fixerTmpDir' => \sys_get_temp_dir() . '/phpstan-fixer']);
        $configurator->addDynamicParameters(['singleReflectionFile' => $singleReflectionFile]);
        $configurator->addConfig($this->configDirectory . '/config.neon');
        foreach ($additionalConfigFiles as $additionalConfigFile) {
            $configurator->addConfig($additionalConfigFile);
        }
        $container = $configurator->createContainer();
        \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection::$phpVersion = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion::class)->getVersionId();
        \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\BetterReflection::populate(
            $container->getService('betterReflectionSourceLocator'),
            // @phpstan-ignore-line
            $container->getService('betterReflectionClassReflector'),
            // @phpstan-ignore-line
            $container->getService('betterReflectionFunctionReflector'),
            // @phpstan-ignore-line
            $container->getService('betterReflectionConstantReflector'),
            // @phpstan-ignore-line
            $container->getService('phpParserDecorator'),
            // @phpstan-ignore-line
            $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class)
        );
        /** @var Broker $broker */
        $broker = $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::registerInstance($broker);
        $container->getService('typeSpecifier');
        return $container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container::class);
    }
    public function clearOldContainers(string $tempDirectory) : void
    {
        $configurator = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Configurator(new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\LoaderFactory($this->fileHelper, $this->rootDirectory, $this->currentWorkingDirectory, null));
        $configurator->setDebugMode(\true);
        $configurator->setTempDirectory($tempDirectory);
        $finder = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Finder();
        $finder->name('Container_*')->in($configurator->getContainerCacheDirectory());
        $twoDaysAgo = \time() - 24 * 60 * 60 * 2;
        foreach ($finder as $containerFile) {
            $path = $containerFile->getRealPath();
            if ($path === \false) {
                continue;
            }
            if ($containerFile->getATime() > $twoDaysAgo) {
                continue;
            }
            if ($containerFile->getCTime() > $twoDaysAgo) {
                continue;
            }
            @\unlink($path);
        }
    }
    public function getCurrentWorkingDirectory() : string
    {
        return $this->currentWorkingDirectory;
    }
    public function getRootDirectory() : string
    {
        return $this->rootDirectory;
    }
    public function getConfigDirectory() : string
    {
        return $this->configDirectory;
    }
}
