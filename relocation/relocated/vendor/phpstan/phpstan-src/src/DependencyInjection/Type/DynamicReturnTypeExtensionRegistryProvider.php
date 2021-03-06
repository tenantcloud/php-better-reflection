<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
interface DynamicReturnTypeExtensionRegistryProvider
{
    public function getRegistry() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
}
