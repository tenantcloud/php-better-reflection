<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
class LazyDynamicReturnTypeExtensionRegistryProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicReturnTypeExtensionRegistry $registry = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider::class), $this->container->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
