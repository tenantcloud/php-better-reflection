<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\SimpleXMLElementProperty;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertiesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
class SimpleXMLElementClassPropertyReflectionExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    public function hasProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        return $classReflection->getName() === 'SimpleXMLElement' || $classReflection->isSubclassOf('SimpleXMLElement');
    }
    public function getProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\SimpleXMLElementProperty($classReflection, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($classReflection->getName()));
    }
}
