<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
interface ReflectionProviderProvider
{
    public function getReflectionProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
}
