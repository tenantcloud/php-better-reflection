<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
class RegistryFactory
{
    public const RULE_TAG = 'phpstan.rules.rule';
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function create() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Registry($this->container->getServicesByTag(self::RULE_TAG));
    }
}
