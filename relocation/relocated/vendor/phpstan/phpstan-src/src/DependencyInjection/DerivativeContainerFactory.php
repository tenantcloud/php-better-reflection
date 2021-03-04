<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

class DerivativeContainerFactory
{
    private string $currentWorkingDirectory;
    private string $tempDirectory;
    /** @var string[] */
    private array $additionalConfigFiles;
    /** @var string[] */
    private array $analysedPaths;
    /** @var string[] */
    private array $composerAutoloaderProjectPaths;
    /** @var string[] */
    private array $analysedPathsFromConfig;
    private string $usedLevel;
    private ?string $generateBaselineFile;
    /**
     * @param string $currentWorkingDirectory
     * @param string $tempDirectory
     * @param string[] $additionalConfigFiles
     * @param string[] $analysedPaths
     * @param string[] $composerAutoloaderProjectPaths
     * @param string[] $analysedPathsFromConfig
     * @param string $usedLevel
     */
    public function __construct(string $currentWorkingDirectory, string $tempDirectory, array $additionalConfigFiles, array $analysedPaths, array $composerAutoloaderProjectPaths, array $analysedPathsFromConfig, string $usedLevel, ?string $generateBaselineFile)
    {
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->tempDirectory = $tempDirectory;
        $this->additionalConfigFiles = $additionalConfigFiles;
        $this->analysedPaths = $analysedPaths;
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
        $this->analysedPathsFromConfig = $analysedPathsFromConfig;
        $this->usedLevel = $usedLevel;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    /**
     * @param string[] $additionalConfigFiles
     * @return \PHPStan\DependencyInjection\Container
     */
    public function create(array $additionalConfigFiles) : \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container
    {
        $containerFactory = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\ContainerFactory($this->currentWorkingDirectory);
        return $containerFactory->create($this->tempDirectory, \array_merge($this->additionalConfigFiles, $additionalConfigFiles), $this->analysedPaths, $this->composerAutoloaderProjectPaths, $this->analysedPathsFromConfig, $this->usedLevel, $this->generateBaselineFile);
    }
}
