<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
interface ReadWritePropertiesExtension
{
    public function isAlwaysRead(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isAlwaysWritten(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
    public function isInitialized(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool;
}
