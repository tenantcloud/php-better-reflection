<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Cache;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Random;
use TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter;
class FileCacheStorage implements \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\CacheStorage
{
    private string $directory;
    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }
    private function makeDir(string $directory) : void
    {
        if (\is_dir($directory)) {
            return;
        }
        $result = @\mkdir($directory, 0777);
        if ($result === \false) {
            \clearstatcache();
            if (\is_dir($directory)) {
                return;
            }
            $error = \error_get_last();
            throw new \InvalidArgumentException(\sprintf('Failed to create directory "%s" (%s).', $this->directory, $error !== null ? $error['message'] : 'unknown cause'));
        }
    }
    /**
     * @param string $key
     * @param string $variableKey
     * @return mixed|null
     */
    public function load(string $key, string $variableKey)
    {
        return (function (string $key, string $variableKey) {
            [, , $filePath] = $this->getFilePaths($key);
            if (!\is_file($filePath)) {
                return null;
            }
            $cacheItem = (require $filePath);
            if (!$cacheItem instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\CacheItem) {
                return null;
            }
            if (!$cacheItem->isVariableKeyValid($variableKey)) {
                return null;
            }
            return $cacheItem->getData();
        })($key, $variableKey);
    }
    /**
     * @param string $key
     * @param string $variableKey
     * @param mixed $data
     * @return void
     */
    public function save(string $key, string $variableKey, $data) : void
    {
        [$firstDirectory, $secondDirectory, $path] = $this->getFilePaths($key);
        $this->makeDir($this->directory);
        $this->makeDir($firstDirectory);
        $this->makeDir($secondDirectory);
        $tmpPath = \sprintf('%s/%s.tmp', $this->directory, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Random::generate());
        $errorBefore = \error_get_last();
        $exported = @\var_export(new \TenantCloud\BetterReflection\Relocated\PHPStan\Cache\CacheItem($variableKey, $data), \true);
        $errorAfter = \error_get_last();
        if ($errorAfter !== null && $errorBefore !== $errorAfter) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Error occurred while saving item %s (%s) to cache: %s', $key, $variableKey, $errorAfter['message']));
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\File\FileWriter::write($tmpPath, \sprintf("<?php declare(strict_types = 1);\n\nreturn %s;", $exported));
        $renameSuccess = @\rename($tmpPath, $path);
        if ($renameSuccess) {
            return;
        }
        @\unlink($tmpPath);
        if (\DIRECTORY_SEPARATOR === '/' || !\file_exists($path)) {
            throw new \InvalidArgumentException(\sprintf('Could not write data to cache file %s.', $path));
        }
    }
    /**
     * @param string $key
     * @return array{string, string, string}
     */
    private function getFilePaths(string $key) : array
    {
        $keyHash = \sha1($key);
        $firstDirectory = \sprintf('%s/%s', $this->directory, \substr($keyHash, 0, 2));
        $secondDirectory = \sprintf('%s/%s', $firstDirectory, \substr($keyHash, 2, 2));
        $filePath = \sprintf('%s/%s.php', $secondDirectory, $keyHash);
        return [$firstDirectory, $secondDirectory, $filePath];
    }
}
