<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertiesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
class AnnotationsPropertiesClassReflectionExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertiesClassReflectionExtension
{
    /** @var \PHPStan\Reflection\PropertyReflection[][] */
    private array $properties = [];
    public function hasProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : bool
    {
        if (!isset($this->properties[$classReflection->getCacheKey()])) {
            $this->properties[$classReflection->getCacheKey()] = $this->createProperties($classReflection, $classReflection);
        }
        return isset($this->properties[$classReflection->getCacheKey()][$propertyName]);
    }
    public function getProperty(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->properties[$classReflection->getCacheKey()][$propertyName];
    }
    /**
     * @param \PHPStan\Reflection\ClassReflection $classReflection
     * @param \PHPStan\Reflection\ClassReflection $declaringClass
     * @return \PHPStan\Reflection\PropertyReflection[]
     */
    private function createProperties(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass) : array
    {
        $properties = [];
        foreach ($classReflection->getTraits() as $traitClass) {
            $properties += $this->createProperties($traitClass, $classReflection);
        }
        foreach ($classReflection->getParents() as $parentClass) {
            $properties += $this->createProperties($parentClass, $parentClass);
            foreach ($parentClass->getTraits() as $traitClass) {
                $properties += $this->createProperties($traitClass, $parentClass);
            }
        }
        foreach ($classReflection->getInterfaces() as $interfaceClass) {
            $properties += $this->createProperties($interfaceClass, $interfaceClass);
        }
        $fileName = $classReflection->getFileName();
        if ($fileName === \false) {
            return $properties;
        }
        $propertyTags = $classReflection->getPropertyTags();
        foreach ($propertyTags as $propertyName => $propertyTag) {
            $properties[$propertyName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationPropertyReflection($declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($propertyTag->getType(), $classReflection->getActiveTemplateTypeMap()), $propertyTag->isReadable(), $propertyTag->isWritable());
        }
        return $properties;
    }
}
