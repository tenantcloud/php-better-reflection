<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

interface FileExcluderRawFactory
{
    /**
     * @param string[] $analyseExcludes
     * @return FileExcluder
     */
    public function create(array $analyseExcludes) : \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileExcluder;
}
