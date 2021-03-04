<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type;

use TenantCloud\BetterReflection\Relocated\Composer\Autoload\ClassLoader;
use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception\InvalidFileLocation;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
use function file_get_contents;
/**
 * This source locator uses Composer's built-in ClassLoader to locate files.
 *
 * Note that we use ClassLoader->findFile directory, rather than
 * ClassLoader->loadClass because this library has a strict requirement that we
 * do NOT actually load the classes
 */
class ComposerSourceLocator extends \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\AbstractSourceLocator
{
    /** @var ClassLoader */
    private $classLoader;
    public function __construct(\TenantCloud\BetterReflection\Relocated\Composer\Autoload\ClassLoader $classLoader, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        parent::__construct($astLocator);
        $this->classLoader = $classLoader;
    }
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     * @throws InvalidFileLocation
     */
    protected function createLocatedSource(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource
    {
        if ($identifier->getType()->getName() !== \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CLASS) {
            return null;
        }
        $filename = $this->classLoader->findFile($identifier->getName());
        if (!$filename) {
            return null;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource(\file_get_contents($filename), $filename);
    }
}
