<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

interface MethodsClassReflectionExtension
{
    public function hasMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool;
    public function getMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
}
