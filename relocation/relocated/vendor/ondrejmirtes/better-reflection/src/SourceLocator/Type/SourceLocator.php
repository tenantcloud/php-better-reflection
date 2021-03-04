<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector;
interface SourceLocator
{
    /**
     * Locate some source code.
     *
     * This method should return a LocatedSource value object or `null` if the
     * SourceLocator is unable to locate the source.
     *
     * NOTE: A SourceLocator should *NOT* throw an exception if it is unable to
     * locate the identifier, it should simply return null. If an exception is
     * thrown, it will break the Generic Reflector.
     */
    public function locateIdentifier(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Identifier $identifier) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
    /**
     * Find all identifiers of a type
     *
     * @return Reflection[]
     */
    public function locateIdentifiersByType(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Reflector $reflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\IdentifierType $identifierType) : array;
}
