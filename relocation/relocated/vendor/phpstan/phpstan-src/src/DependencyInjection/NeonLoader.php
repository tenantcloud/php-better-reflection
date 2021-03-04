<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
class NeonLoader extends \TenantCloud\BetterReflection\Relocated\Nette\DI\Config\Loader
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    private ?string $generateBaselineFile;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, ?string $generateBaselineFile)
    {
        $this->fileHelper = $fileHelper;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    /**
     * @param string $file
     * @param bool|null $merge
     * @return mixed[]
     */
    public function load(string $file, ?bool $merge = \true) : array
    {
        if ($this->generateBaselineFile === null) {
            return parent::load($file, $merge);
        }
        $normalizedFile = $this->fileHelper->normalizePath($file);
        if ($this->generateBaselineFile === $normalizedFile) {
            return [];
        }
        return parent::load($file, $merge);
    }
}
