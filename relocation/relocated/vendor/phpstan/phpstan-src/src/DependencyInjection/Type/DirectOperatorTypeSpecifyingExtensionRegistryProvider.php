<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class DirectOperatorTypeSpecifyingExtensionRegistryProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var OperatorTypeSpecifyingExtension[] */
    private array $extensions;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker $broker;
    /**
     * @param \PHPStan\Type\OperatorTypeSpecifyingExtension[] $extensions
     */
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }
    public function setBroker(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function getRegistry() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->broker, $this->extensions);
    }
}
