<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use function file_exists;
use function is_file;
use function is_readable;
use function sprintf;
class FileChecker
{
    /**
     * @throws InvalidFileLocation
     */
    public static function assertReadableFile(string $filename) : void
    {
        if (empty($filename)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation('Filename was empty');
        }
        if (!\file_exists($filename)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation(\sprintf('File "%s" does not exist', $filename));
        }
        if (!\is_readable($filename)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation(\sprintf('File "%s" is not readable', $filename));
        }
        if (!\is_file($filename)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation(\sprintf('"%s" is not a file', $filename));
        }
    }
}
