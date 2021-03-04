<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector $functionReflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector $classReflector, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector $constantReflector) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
