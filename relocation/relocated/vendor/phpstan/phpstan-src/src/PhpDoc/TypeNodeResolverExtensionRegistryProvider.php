<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

interface TypeNodeResolverExtensionRegistryProvider
{
    public function getRegistry() : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry;
}
