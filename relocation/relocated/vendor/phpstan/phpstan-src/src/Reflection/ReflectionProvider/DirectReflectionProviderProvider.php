<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
class DirectReflectionProviderProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
