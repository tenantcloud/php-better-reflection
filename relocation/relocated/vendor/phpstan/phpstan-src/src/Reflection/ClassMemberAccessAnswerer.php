<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

interface ClassMemberAccessAnswerer
{
    public function isInClass() : bool;
    public function getClassReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
    public function canAccessProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool;
    public function canCallMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function canAccessConstant(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection $constantReflection) : bool;
}
