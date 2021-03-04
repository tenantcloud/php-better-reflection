<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
/**
 * This interface is used to ensure a reflector implements these basic methods.
 */
interface Reflector
{
    /**
     * Create a reflection from the named identifier.
     *
     * @throws IdentifierNotFound
     */
    public function reflect(string $identifierName) : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
}
