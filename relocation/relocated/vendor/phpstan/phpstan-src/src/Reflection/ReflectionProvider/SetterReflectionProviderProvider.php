<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
class SetterReflectionProviderProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ReflectionProviderProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    public function setReflectionProvider(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getReflectionProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        return $this->reflectionProvider;
    }
}
