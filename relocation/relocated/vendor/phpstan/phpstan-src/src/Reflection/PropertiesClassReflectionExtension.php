<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

interface PropertiesClassReflectionExtension
{
    public function hasProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool;
    public function getProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
}
