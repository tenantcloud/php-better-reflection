<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Filesystem;

final class SymfonyFilesystem implements \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Filesystem\Filesystem
{
    /** @var \Symfony\Component\Filesystem\Filesystem */
    private $filesystem;
    public function __construct(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Filesystem\Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }
    public function exists(string $dir) : bool
    {
        return $this->filesystem->exists($dir);
    }
    public function remove(string $dir) : void
    {
        $this->filesystem->remove($dir);
    }
    public function mkdir(string $dir) : void
    {
        $this->filesystem->mkdir($dir);
    }
    public function read(string $file) : string
    {
        $content = \file_get_contents($file);
        if ($content === \false) {
            throw new \RuntimeException();
        }
        return $content;
    }
    public function write(string $file, string $data) : void
    {
        \file_put_contents($file, $data);
    }
}
