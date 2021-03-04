<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
class ClassReflectionExtensionRegistry
{
    /** @var \PHPStan\Reflection\PropertiesClassReflectionExtension[] */
    private array $propertiesClassReflectionExtensions;
    /** @var \PHPStan\Reflection\MethodsClassReflectionExtension[] */
    private array $methodsClassReflectionExtensions;
    /**
     * @param \PHPStan\Broker\Broker $broker
     * @param \PHPStan\Reflection\PropertiesClassReflectionExtension[] $propertiesClassReflectionExtensions
     * @param \PHPStan\Reflection\MethodsClassReflectionExtension[] $methodsClassReflectionExtensions
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker $broker, array $propertiesClassReflectionExtensions, array $methodsClassReflectionExtensions)
    {
        foreach (\array_merge($propertiesClassReflectionExtensions, $methodsClassReflectionExtensions) as $extension) {
            if (!$extension instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BrokerAwareExtension) {
                continue;
            }
            $extension->setBroker($broker);
        }
        $this->propertiesClassReflectionExtensions = $propertiesClassReflectionExtensions;
        $this->methodsClassReflectionExtensions = $methodsClassReflectionExtensions;
    }
    /**
     * @return \PHPStan\Reflection\PropertiesClassReflectionExtension[]
     */
    public function getPropertiesClassReflectionExtensions() : array
    {
        return $this->propertiesClassReflectionExtensions;
    }
    /**
     * @return \PHPStan\Reflection\MethodsClassReflectionExtension[]
     */
    public function getMethodsClassReflectionExtensions() : array
    {
        return $this->methodsClassReflectionExtensions;
    }
}
