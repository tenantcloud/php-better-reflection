<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

class SimpleRelativePathHelper implements \TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper
{
    private string $currentWorkingDirectory;
    public function __construct(string $currentWorkingDirectory)
    {
        $this->currentWorkingDirectory = $currentWorkingDirectory;
    }
    public function getRelativePath(string $filename) : string
    {
        if ($this->currentWorkingDirectory !== '' && \strpos($filename, $this->currentWorkingDirectory) === 0) {
            return \substr($filename, \strlen($this->currentWorkingDirectory) + 1);
        }
        return $filename;
    }
}
