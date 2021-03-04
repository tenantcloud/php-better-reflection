<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located;

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper;
/**
 * Value object containing source code that has been located.
 *
 * @internal
 */
class LocatedSource
{
    /** @var string */
    private $source;
    /** @var string|null */
    private $filename;
    /**
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    public function __construct(string $source, ?string $filename)
    {
        if ($filename !== null) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker::assertReadableFile($filename);
            $filename = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper::normalizeWindowsPath($filename);
        }
        $this->source = $source;
        $this->filename = $filename;
    }
    public function getSource() : string
    {
        return $this->source;
    }
    public function getFileName() : ?string
    {
        return $this->filename;
    }
    /**
     * Is the located source in PHP internals?
     */
    public function isInternal() : bool
    {
        return \false;
    }
    public function getExtensionName() : ?string
    {
        return null;
    }
    /**
     * Is the located source produced by eval() or \function_create()?
     */
    public function isEvaled() : bool
    {
        return \false;
    }
}
