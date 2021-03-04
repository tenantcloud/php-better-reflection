<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodsClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
class AnnotationsMethodsClassReflectionExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodsClassReflectionExtension
{
    /** @var MethodReflection[][] */
    private array $methods = [];
    public function hasMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        if (!isset($this->methods[$classReflection->getCacheKey()])) {
            $this->methods[$classReflection->getCacheKey()] = $this->createMethods($classReflection, $classReflection);
        }
        return isset($this->methods[$classReflection->getCacheKey()][$methodName]);
    }
    public function getMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        return $this->methods[$classReflection->getCacheKey()][$methodName];
    }
    /**
     * @param ClassReflection $classReflection
     * @param ClassReflection $declaringClass
     * @return MethodReflection[]
     */
    private function createMethods(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass) : array
    {
        $methods = [];
        foreach ($classReflection->getTraits() as $traitClass) {
            $methods += $this->createMethods($traitClass, $classReflection);
        }
        foreach ($classReflection->getParents() as $parentClass) {
            $methods += $this->createMethods($parentClass, $parentClass);
            foreach ($parentClass->getTraits() as $traitClass) {
                $methods += $this->createMethods($traitClass, $parentClass);
            }
        }
        foreach ($classReflection->getInterfaces() as $interfaceClass) {
            $methods += $this->createMethods($interfaceClass, $interfaceClass);
        }
        $fileName = $classReflection->getFileName();
        if ($fileName === \false) {
            return $methods;
        }
        $methodTags = $classReflection->getMethodTags();
        foreach ($methodTags as $methodName => $methodTag) {
            $parameters = [];
            foreach ($methodTag->getParameters() as $parameterName => $parameterTag) {
                $parameters[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationsMethodParameterReflection($parameterName, $parameterTag->getType(), $parameterTag->passedByReference(), $parameterTag->isOptional(), $parameterTag->isVariadic(), $parameterTag->getDefaultValue());
            }
            $methods[$methodName] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations\AnnotationMethodReflection($methodName, $declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($methodTag->getReturnType(), $classReflection->getActiveTemplateTypeMap()), $parameters, $methodTag->isStatic(), $this->detectMethodVariadic($parameters));
        }
        return $methods;
    }
    /**
     * @param AnnotationsMethodParameterReflection[] $parameters
     * @return bool
     */
    private function detectMethodVariadic(array $parameters) : bool
    {
        if ($parameters === []) {
            return \false;
        }
        $possibleVariadicParameterIndex = \count($parameters) - 1;
        $possibleVariadicParameter = $parameters[$possibleVariadicParameterIndex];
        return $possibleVariadicParameter->isVariadic();
    }
}
