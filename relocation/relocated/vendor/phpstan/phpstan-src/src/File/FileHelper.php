<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings;
class FileHelper
{
    private string $workingDirectory;
    public function __construct(string $workingDirectory)
    {
        $this->workingDirectory = $this->normalizePath($workingDirectory);
    }
    public function getWorkingDirectory() : string
    {
        return $this->workingDirectory;
    }
    public function absolutizePath(string $path) : string
    {
        if (\DIRECTORY_SEPARATOR === '/') {
            if (\substr($path, 0, 1) === '/') {
                return $path;
            }
        } else {
            if (\substr($path, 1, 1) === ':') {
                return $path;
            }
        }
        if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::startsWith($path, 'phar://')) {
            return $path;
        }
        return \rtrim($this->getWorkingDirectory(), '/\\') . \DIRECTORY_SEPARATOR . \ltrim($path, '/\\');
    }
    public function normalizePath(string $originalPath, string $directorySeparator = \DIRECTORY_SEPARATOR) : string
    {
        $matches = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($originalPath, '~^([a-z]+)\\:\\/\\/(.+)~');
        if ($matches !== null) {
            [, $scheme, $path] = $matches;
        } else {
            $scheme = null;
            $path = $originalPath;
        }
        $path = \str_replace('\\', '/', $path);
        $path = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::replace($path, '~/{2,}~', '/');
        $pathRoot = \strpos($path, '/') === 0 ? $directorySeparator : '';
        $pathParts = \explode('/', \trim($path, '/'));
        $normalizedPathParts = [];
        foreach ($pathParts as $pathPart) {
            if ($pathPart === '.') {
                continue;
            }
            if ($pathPart === '..') {
                /** @var string $removedPart */
                $removedPart = \array_pop($normalizedPathParts);
                if ($scheme === 'phar' && \substr($removedPart, -5) === '.phar') {
                    $scheme = null;
                }
            } else {
                $normalizedPathParts[] = $pathPart;
            }
        }
        return ($scheme !== null ? $scheme . '://' : '') . $pathRoot . \implode($directorySeparator, $normalizedPathParts);
    }
}
