<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

class LazyTypeNodeResolverExtensionRegistryProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry $registry = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry($this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolver::class), $this->container->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG));
        }
        return $this->registry;
    }
}
