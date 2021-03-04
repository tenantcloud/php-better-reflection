<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Broker;

use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
class BrokerFactory
{
    public const PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG = 'phpstan.broker.propertiesClassReflectionExtension';
    public const METHODS_CLASS_REFLECTION_EXTENSION_TAG = 'phpstan.broker.methodsClassReflectionExtension';
    public const DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG = 'phpstan.broker.dynamicMethodReturnTypeExtension';
    public const DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG = 'phpstan.broker.dynamicStaticMethodReturnTypeExtension';
    public const DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG = 'phpstan.broker.dynamicFunctionReturnTypeExtension';
    public const OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG = 'phpstan.broker.operatorTypeSpecifyingExtension';
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker($this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class), $this->container->getParameter('universalObjectCratesClasses'));
    }
}
