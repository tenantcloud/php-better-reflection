<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Loader;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
class LoaderFactory
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    private string $rootDir;
    private string $currentWorkingDirectory;
    private ?string $generateBaselineFile;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, string $rootDir, string $currentWorkingDirectory, ?string $generateBaselineFile)
    {
        $this->fileHelper = $fileHelper;
        $this->rootDir = $rootDir;
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    public function createLoader() : \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Loader
    {
        $loader = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonLoader($this->fileHelper, $this->generateBaselineFile);
        $loader->addAdapter('dist', \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->addAdapter('neon', \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->setParameters(['rootDir' => $this->rootDir, 'currentWorkingDirectory' => $this->currentWorkingDirectory]);
        return $loader;
    }
}
