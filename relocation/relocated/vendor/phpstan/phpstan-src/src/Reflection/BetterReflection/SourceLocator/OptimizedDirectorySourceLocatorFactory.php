<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder;
class OptimizedDirectorySourceLocatorFactory
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder $fileFinder;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher, \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinder $fileFinder)
    {
        $this->fileNodesFetcher = $fileNodesFetcher;
        $this->fileFinder = $fileFinder;
    }
    public function createByDirectory(string $directory) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocator
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocator($this->fileNodesFetcher, $this->fileFinder->findFiles([$directory])->getFiles());
    }
    /**
     * @param string[] $files
     * @return OptimizedDirectorySourceLocator
     */
    public function createByFiles(array $files) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocator
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocator($this->fileNodesFetcher, $files);
    }
}
