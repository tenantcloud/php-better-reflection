<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class LazyOperatorTypeSpecifyingExtensionRegistryProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry $registry = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class), $this->container->getServicesByTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
