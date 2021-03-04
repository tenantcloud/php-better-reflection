<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\FailedToParseJson;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\InvalidProjectDirectory;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\MissingComposerJson;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr0Mapping;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr4Mapping;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\PsrAutoloaderLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator;
use function array_filter;
use function array_map;
use function array_merge;
use function file_exists;
use function file_get_contents;
use function is_array;
use function is_dir;
use function json_decode;
use function realpath;
final class MakeLocatorForComposerJson
{
    public function __invoke(string $installationPath, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator $astLocator) : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $realInstallationPath = (string) \realpath($installationPath);
        if (!\is_dir($realInstallationPath)) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\InvalidProjectDirectory::atPath($installationPath);
        }
        $composerJsonPath = $realInstallationPath . '/composer.json';
        if (!\file_exists($composerJsonPath)) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\MissingComposerJson::inProjectPath($installationPath);
        }
        /** @var array{autoload: array{classmap: array<int, string>, files: array<int, string>, psr-4: array<string, array<int, string>>, psr-0: array<string, array<int, string>>}}|null $composer */
        $composer = \json_decode((string) \file_get_contents($composerJsonPath), \true);
        if (!\is_array($composer)) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\FailedToParseJson::inFile($composerJsonPath);
        }
        $pathPrefix = $realInstallationPath . '/';
        $classMapPaths = $this->prefixPaths($this->packageToClassMapPaths($composer), $pathPrefix);
        $classMapFiles = \array_filter($classMapPaths, 'is_file');
        $classMapDirectories = \array_filter($classMapPaths, 'is_dir');
        $filePaths = $this->prefixPaths($this->packageToFilePaths($composer), $pathPrefix);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AggregateSourceLocator(\array_merge([new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\PsrAutoloaderLocator(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr4Mapping::fromArrayMappings($this->prefixWithInstallationPath($this->packageToPsr4AutoloadNamespaces($composer), $pathPrefix)), $astLocator), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\PsrAutoloaderLocator(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Psr\Psr0Mapping::fromArrayMappings($this->prefixWithInstallationPath($this->packageToPsr0AutoloadNamespaces($composer), $pathPrefix)), $astLocator), new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator($classMapDirectories, $astLocator)], ...\array_map(static function (string $file) use($astLocator) : array {
            return [new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SingleFileSourceLocator($file, $astLocator)];
        }, \array_merge($classMapFiles, $filePaths))));
    }
    /**
     * @param array{autoload: array{classmap: array<int, string>, files: array<int, string>, psr-4: array<string, array<int, string>>, psr-0: array<string, array<int, string>>}} $package
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
     * @param array{autoload: array{classmap: array<int, string>, files: array<int, string>, psr-4: array<string, array<int, string>>, psr-0: array<string, array<int, string>>}} $package
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
     * @param array{autoload: array{classmap: array<int, string>, files: array<int, string>, psr-4: array<string, array<int, string>>, psr-0: array<string, array<int, string>>}} $package
     *
     * @return array<int, string>
     */
    private function packageToClassMapPaths(array $package) : array
    {
        return $package['autoload']['classmap'] ?? [];
    }
    /**
     * @param array{autoload: array{classmap: array<int, string>, files: array<int, string>, psr-4: array<string, array<int, string>>, psr-0: array<string, array<int, string>>}} $package
     *
     * @return array<int, string>
     */
    private function packageToFilePaths(array $package) : array
    {
        return $package['autoload']['files'] ?? [];
    }
    /**
     * @param array<string, array<int, string>> $paths
     *
     * @return array<string, array<int, string>>
     */
    private function prefixWithInstallationPath(array $paths, string $trimmedInstallationPath) : array
    {
        return \array_map(function (array $paths) use($trimmedInstallationPath) : array {
            return $this->prefixPaths($paths, $trimmedInstallationPath);
        }, $paths);
    }
    /**
     * @param array<int, string> $paths
     *
     * @return array<int, string>
     */
    private function prefixPaths(array $paths, string $prefix) : array
    {
        return \array_map(static function (string $path) use($prefix) {
            return $prefix . $path;
        }, $paths);
    }
}
