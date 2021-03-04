<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

class FileExcluder
{
    /**
     * Directories to exclude from analysing
     *
     * @var string[]
     */
    private array $analyseExcludes;
    /**
     * @param FileHelper $fileHelper
     * @param string[] $analyseExcludes
     * @param string[] $stubFiles
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, array $analyseExcludes, array $stubFiles)
    {
        $this->analyseExcludes = \array_map(function (string $exclude) use($fileHelper) : string {
            $len = \strlen($exclude);
            $trailingDirSeparator = $len > 0 && \in_array($exclude[$len - 1], ['\\', '/'], \true);
            $normalized = $fileHelper->normalizePath($exclude);
            if ($trailingDirSeparator) {
                $normalized .= \DIRECTORY_SEPARATOR;
            }
            if ($this->isFnmatchPattern($normalized)) {
                return $normalized;
            }
            return $fileHelper->absolutizePath($normalized);
        }, \array_merge($analyseExcludes, $stubFiles));
    }
    public function isExcludedFromAnalysing(string $file) : bool
    {
        foreach ($this->analyseExcludes as $exclude) {
            if (\strpos($file, $exclude) === 0) {
                return \true;
            }
            $isWindows = \DIRECTORY_SEPARATOR === '\\';
            if ($isWindows) {
                $fnmatchFlags = \FNM_NOESCAPE | \FNM_CASEFOLD;
            } else {
                $fnmatchFlags = 0;
            }
            if ($this->isFnmatchPattern($exclude) && \fnmatch($exclude, $file, $fnmatchFlags)) {
                return \true;
            }
        }
        return \false;
    }
    private function isFnmatchPattern(string $path) : bool
    {
        return \preg_match('~[*?[\\]]~', $path) > 0;
    }
}
