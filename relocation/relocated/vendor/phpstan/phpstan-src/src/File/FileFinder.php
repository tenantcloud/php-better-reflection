<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Finder;
class FileFinder
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileExcluder $fileExcluder;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    /** @var string[] */
    private array $fileExtensions;
    /**
     * @param FileExcluder $fileExcluder
     * @param FileHelper $fileHelper
     * @param string[] $fileExtensions
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileExcluder $fileExcluder, \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, array $fileExtensions)
    {
        $this->fileExcluder = $fileExcluder;
        $this->fileHelper = $fileHelper;
        $this->fileExtensions = $fileExtensions;
    }
    /**
     * @param string[] $paths
     * @return FileFinderResult
     */
    public function findFiles(array $paths) : \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinderResult
    {
        $onlyFiles = \true;
        $files = [];
        foreach ($paths as $path) {
            if (!\file_exists($path)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\File\PathNotFoundException($path);
            } elseif (\is_file($path)) {
                $files[] = $this->fileHelper->normalizePath($path);
            } else {
                $finder = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Finder\Finder();
                $finder->followLinks();
                foreach ($finder->files()->name('*.{' . \implode(',', $this->fileExtensions) . '}')->in($path) as $fileInfo) {
                    $files[] = $this->fileHelper->normalizePath($fileInfo->getPathname());
                    $onlyFiles = \false;
                }
            }
        }
        $files = \array_values(\array_filter($files, function (string $file) : bool {
            return !$this->fileExcluder->isExcludedFromAnalysing($file);
        }));
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileFinderResult($files, $onlyFiles);
    }
}
