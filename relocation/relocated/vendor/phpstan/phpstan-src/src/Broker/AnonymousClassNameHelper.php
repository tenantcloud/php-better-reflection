<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Broker;

use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper;
class AnonymousClassNameHelper
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\File\FileHelper $fileHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->relativePathHelper = $relativePathHelper;
    }
    public function getAnonymousClassName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $classNode, string $filename) : string
    {
        if (isset($classNode->namespacedName)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $filename = $this->relativePathHelper->getRelativePath($this->fileHelper->normalizePath($filename, '/'));
        return \sprintf('AnonymousClass%s', \md5(\sprintf('%s:%s', $filename, $classNode->getLine())));
    }
}
