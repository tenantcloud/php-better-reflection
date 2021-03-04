<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator as AstLocator;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
abstract class AbstractSourceLocator implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var AstLocator */
    private $astLocator;
    /**
     * Children should implement this method and return a LocatedSource object
     * which contains the source and the file from which it was located.
     *
     * @example
     *   return new LocatedSource(['<?php class Foo {}', null]);
     *   return new LocatedSource([\file_get_contents('Foo.php'), 'Foo.php']);
     */
    protected abstract function createLocatedSource(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Located\LocatedSource;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Ast\Locator $astLocator)
    {
        $this->astLocator = $astLocator;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        $locatedSource = $this->createLocatedSource($identifier);
        if (!$locatedSource) {
            return null;
        }
        try {
            return $this->astLocator->findReflection($reflector, $locatedSource, $identifier);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $exception) {
            return null;
        }
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public final function locateIdentifiersByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        $locatedSource = $this->createLocatedSource(new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier::WILDCARD, $identifierType));
        if (!$locatedSource) {
            return [];
        }
        return $this->astLocator->findReflectionsOfType($reflector, $locatedSource, $identifierType);
    }
}
