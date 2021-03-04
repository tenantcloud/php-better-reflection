<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Mixin;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\OutOfClassScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodsClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class MixinMethodsClassReflectionExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodsClassReflectionExtension
{
    /** @var string[] */
    private array $mixinExcludeClasses;
    /**
     * @param string[] $mixinExcludeClasses
     */
    public function __construct(array $mixinExcludeClasses)
    {
        $this->mixinExcludeClasses = $mixinExcludeClasses;
    }
    public function hasMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        return $this->findMethod($classReflection, $methodName) !== null;
    }
    public function getMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $method = $this->findMethod($classReflection, $methodName);
        if ($method === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $method;
    }
    private function findMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $mixinTypes = $classReflection->getResolvedMixinTypes();
        foreach ($mixinTypes as $type) {
            if (\count(\array_intersect(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getDirectClassNames($type), $this->mixinExcludeClasses)) > 0) {
                continue;
            }
            if (!$type->hasMethod($methodName)->yes()) {
                continue;
            }
            $method = $type->getMethod($methodName, new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\OutOfClassScope());
            $static = $method->isStatic();
            if (!$static && $classReflection->hasNativeMethod('__callStatic') && !$classReflection->hasNativeMethod('__call')) {
                $static = \true;
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Mixin\MixinMethodReflection($method, $static);
        }
        foreach ($classReflection->getParents() as $parentClass) {
            $method = $this->findMethod($parentClass, $methodName);
            if ($method === null) {
                continue;
            }
            return $method;
        }
        return null;
    }
}
