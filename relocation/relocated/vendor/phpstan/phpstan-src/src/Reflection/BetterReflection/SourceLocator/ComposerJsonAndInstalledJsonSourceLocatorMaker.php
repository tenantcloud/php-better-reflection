<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Json;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr0Mapping;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr4Mapping;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader;
class ComposerJsonAndInstalledJsonSourceLocatorMaker
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository $optimizedDirectorySourceLocatorRepository;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedPsrAutoloaderLocatorFactory $optimizedPsrAutoloaderLocatorFactory;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory $optimizedDirectorySourceLocatorFactory;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository $optimizedDirectorySourceLocatorRepository, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedPsrAutoloaderLocatorFactory $optimizedPsrAutoloaderLocatorFactory, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorFactory $optimizedDirectorySourceLocatorFactory)
    {
        $this->optimizedDirectorySourceLocatorRepository = $optimizedDirectorySourceLocatorRepository;
        $this->optimizedPsrAutoloaderLocatorFactory = $optimizedPsrAutoloaderLocatorFactory;
        $this->optimizedDirectorySourceLocatorFactory = $optimizedDirectorySourceLocatorFactory;
    }
    public function create(string $projectInstallationPath) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $composerJsonPath = $projectInstallationPath . '/composer.json';
        if (!\is_file($composerJsonPath)) {
            return null;
        }
        $installedJsonPath = $projectInstallationPath . '/vendor/composer/installed.json';
        if (!\is_file($installedJsonPath)) {
            return null;
        }
        $installedJsonDirectoryPath = \dirname($installedJsonPath);
        try {
            $composerJsonContents = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($composerJsonPath);
            $composer = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($composerJsonContents, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\File\CouldNotReadFileException|\TenantCloud\BetterReflection\Relocated\Nette\Utils\JsonException $e) {
            return null;
        }
        try {
            $installedJsonContents = \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileReader::read($installedJsonPath);
            $installedJson = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::decode($installedJsonContents, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\File\CouldNotReadFileException|\TenantCloud\BetterReflection\Relocated\Nette\Utils\JsonException $e) {
            return null;
        }
        $installed = $installedJson['packages'] ?? $installedJson;
        $classMapPaths = \array_merge($this->prefixPaths($this->packageToClassMapPaths($composer), $projectInstallationPath . '/'), ...\array_map(function (array $package) use($projectInstallationPath, $installedJsonDirectoryPath) : array {
            return $this->prefixPaths($this->packageToClassMapPaths($package), $this->packagePrefixPath($projectInstallationPath, $installedJsonDirectoryPath, $package));
        }, $installed));
        $classMapFiles = \array_filter($classMapPaths, 'is_file');
        $classMapDirectories = \array_filter($classMapPaths, 'is_dir');
        $filePaths = \array_merge($this->prefixPaths($this->packageToFilePaths($composer), $projectInstallationPath . '/'), ...\array_map(function (array $package) use($projectInstallationPath, $installedJsonDirectoryPath) : array {
            return $this->prefixPaths($this->packageToFilePaths($package), $this->packagePrefixPath($projectInstallationPath, $installedJsonDirectoryPath, $package));
        }, $installed));
        $locators = [];
        $locators[] = $this->optimizedPsrAutoloaderLocatorFactory->create(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr4Mapping::fromArrayMappings(\array_merge_recursive($this->prefixWithInstallationPath($this->packageToPsr4AutoloadNamespaces($composer), $projectInstallationPath), ...\array_map(function (array $package) use($projectInstallationPath, $installedJsonDirectoryPath) : array {
            return $this->prefixWithPackagePath($this->packageToPsr4AutoloadNamespaces($package), $projectInstallationPath, $installedJsonDirectoryPath, $package);
        }, $installed))));
        $locators[] = $this->optimizedPsrAutoloaderLocatorFactory->create(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr0Mapping::fromArrayMappings(\array_merge_recursive($this->prefixWithInstallationPath($this->packageToPsr0AutoloadNamespaces($composer), $projectInstallationPath), ...\array_map(function (array $package) use($projectInstallationPath, $installedJsonDirectoryPath) : array {
            return $this->prefixWithPackagePath($this->packageToPsr0AutoloadNamespaces($package), $projectInstallationPath, $installedJsonDirectoryPath, $package);
        }, $installed))));
        foreach ($classMapDirectories as $classMapDirectory) {
            if (!\is_dir($classMapDirectory)) {
                continue;
            }
            $locators[] = $this->optimizedDirectorySourceLocatorRepository->getOrCreate($classMapDirectory);
        }
        $files = [];
        foreach (\array_merge($classMapFiles, $filePaths) as $file) {
            if (!\is_file($file)) {
                continue;
            }
            $files[] = $file;
        }
        if (\count($files) > 0) {
            $locators[] = $this->optimizedDirectorySourceLocatorFactory->createByFiles($files);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators);
    }
    /**
     * @param mixed[] $package
     *
     * @return array<string, array<int, string>>
     */
    private function packageToPsr4AutoloadNamespaces(array $package) : array
    {
        return \array_map(static function ($namespacePaths) : array {
            return (array) $namespacePaths;
        }, $package['autoload']['psr-4'] ?? []);
    }
    /**
     * @param mixed[] $package
     *
     * @return array<string, array<int, string>>
     */
    private function packageToPsr0AutoloadNamespaces(array $package) : array
    {
        return \array_map(static function ($namespacePaths) : array {
            return (array) $namespacePaths;
        }, $package['autoload']['psr-0'] ?? []);
    }
    /**
     * @param mixed[] $package
     *
     * @return array<int, string>
     */
    private function packageToClassMapPaths(array $package) : array
    {
        return $package['autoload']['classmap'] ?? [];
    }
    /**
     * @param mixed[] $package
     *
     * @return array<int, string>
     */
    private function packageToFilePaths(array $package) : array
    {
        return $package['autoload']['files'] ?? [];
    }
    /**
     * @param mixed[] $package
     */
    private function packagePrefixPath(string $projectInstallationPath, string $installedJsonDirectoryPath, array $package) : string
    {
        if (\array_key_exists('install-path', $package)) {
            return $installedJsonDirectoryPath . '/' . $package['install-path'] . '/';
        }
        return $projectInstallationPath . '/vendor/' . $package['name'] . '/';
    }
    /**
     * @param array<string, array<int, string>> $paths
     * @param array<string, array<int, string>> $package
     *
     * @return array<string, array<int, string>>
     */
    private function prefixWithPackagePath(array $paths, string $projectInstallationPath, string $installedJsonDirectoryPath, array $package) : array
    {
        $prefix = $this->packagePrefixPath($projectInstallationPath, $installedJsonDirectoryPath, $package);
        return \array_map(function (array $paths) use($prefix) : array {
            return $this->prefixPaths($paths, $prefix);
        }, $paths);
    }
    /**
     * @param array<int|string, array<string>> $paths
     *
     * @return array<int|string, array<string>>
     */
    private function prefixWithInstallationPath(array $paths, string $trimmedInstallationPath) : array
    {
        return \array_map(function (array $paths) use($trimmedInstallationPath) : array {
            return $this->prefixPaths($paths, $trimmedInstallationPath . '/');
        }, $paths);
    }
    /**
     * @param array<int, string> $paths
     *
     * @return array<int, string>
     */
    private function prefixPaths(array $paths, string $prefix) : array
    {
        return \array_map(static function (string $path) use($prefix) : string {
            return $prefix . $path;
        }, $paths);
    }
}
