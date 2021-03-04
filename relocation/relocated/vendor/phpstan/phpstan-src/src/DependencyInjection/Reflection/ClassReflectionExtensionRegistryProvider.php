<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflectionExtensionRegistry;
interface ClassReflectionExtensionRegistryProvider
{
    public function getRegistry() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflectionExtensionRegistry;
}
