<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

interface RelativePathHelper
{
    public function getRelativePath(string $filename) : string;
}
