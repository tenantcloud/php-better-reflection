<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type;

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use function file_get_contents;
/**
 * This source locator loads an entire file, specified in the constructor
 * argument.
 *
 * This is useful for loading a class that does not have a namespace. This is
 * also the class required if you want to use Reflector->getClassesFromFile
 * (which loads all classes from specified file)
 */
class SingleFileSourceLocator extends \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var string */
    private $fileName;
    /**
     * @throws InvalidFileLocation
     */
    public function __construct(string $fileName, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\FileChecker::assertReadableFile($fileName);
        parent::__construct($astLocator);
        $this->fileName = $fileName;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource(\file_get_contents($this->fileName), $this->fileName);
    }
}
