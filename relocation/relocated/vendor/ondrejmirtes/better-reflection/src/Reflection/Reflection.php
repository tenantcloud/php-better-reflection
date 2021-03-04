<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection;

/**
 * This interface is used internally by the Generic reflector in order to
 * ensure we are working with BetterReflection reflections.
 *
 * @internal
 */
interface Reflection
{
    /**
     * Get the name of the reflection (e.g. if this is a ReflectionClass this
     * will be the class name).
     */
    public function getName() : string;
}
