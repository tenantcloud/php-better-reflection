<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
class LazyReflectionProviderProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getReflectionProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider::class);
    }
}
