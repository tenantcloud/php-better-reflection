<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Command;

use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\Internal\BytesHelper;
use function memory_get_peak_usage;
class InceptionResult
{
    /** @var callable(): (array{string[], bool}) */
    private $filesCallback;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $stdOutput;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $errorOutput;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    private bool $isDefaultLevelUsed;
    private string $memoryLimitFile;
    private ?string $projectConfigFile;
    /** @var mixed[]|null */
    private ?array $projectConfigArray;
    private ?string $generateBaselineFile;
    /**
     * @param callable(): (array{string[], bool}) $filesCallback
     * @param Output $stdOutput
     * @param Output $errorOutput
     * @param \PHPStan\DependencyInjection\Container $container
     * @param bool $isDefaultLevelUsed
     * @param string $memoryLimitFile
     * @param string|null $projectConfigFile
     * @param mixed[] $projectConfigArray
     * @param string|null $generateBaselineFile
     */
    public function __construct(callable $filesCallback, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $stdOutput, \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output $errorOutput, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container, bool $isDefaultLevelUsed, string $memoryLimitFile, ?string $projectConfigFile, ?array $projectConfigArray, ?string $generateBaselineFile)
    {
        $this->filesCallback = $filesCallback;
        $this->stdOutput = $stdOutput;
        $this->errorOutput = $errorOutput;
        $this->container = $container;
        $this->isDefaultLevelUsed = $isDefaultLevelUsed;
        $this->memoryLimitFile = $memoryLimitFile;
        $this->projectConfigFile = $projectConfigFile;
        $this->projectConfigArray = $projectConfigArray;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    /**
     * @return array{string[], bool}
     */
    public function getFiles() : array
    {
        $callback = $this->filesCallback;
        return $callback();
    }
    public function getStdOutput() : \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output
    {
        return $this->stdOutput;
    }
    public function getErrorOutput() : \TenantCloud\BetterReflection\Relocated\PHPStan\Command\Output
    {
        return $this->errorOutput;
    }
    public function getContainer() : \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container
    {
        return $this->container;
    }
    public function isDefaultLevelUsed() : bool
    {
        return $this->isDefaultLevelUsed;
    }
    public function getProjectConfigFile() : ?string
    {
        return $this->projectConfigFile;
    }
    /**
     * @return mixed[]|null
     */
    public function getProjectConfigArray() : ?array
    {
        return $this->projectConfigArray;
    }
    public function getGenerateBaselineFile() : ?string
    {
        return $this->generateBaselineFile;
    }
    public function handleReturn(int $exitCode) : int
    {
        if ($this->getErrorOutput()->isVerbose()) {
            $this->getErrorOutput()->writeLineFormatted(\sprintf('Used memory: %s', \TenantCloud\BetterReflection\Relocated\PHPStan\Internal\BytesHelper::bytes(\memory_get_peak_usage(\true))));
        }
        @\unlink($this->memoryLimitFile);
        return $exitCode;
    }
}
