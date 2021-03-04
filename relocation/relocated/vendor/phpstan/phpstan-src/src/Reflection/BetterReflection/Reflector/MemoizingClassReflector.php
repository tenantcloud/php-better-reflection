<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector;
final class MemoizingClassReflector extends \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ClassReflector
{
    /** @var array<string, \PHPStan\BetterReflection\Reflection\ReflectionClass|\Throwable> */
    private array $reflections = [];
    /**
     * Create a ReflectionClass for the specified $className.
     *
     * @return \PHPStan\BetterReflection\Reflection\ReflectionClass
     *
     * @throws \PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound
     */
    public function reflect(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->reflections[$lowerClassName])) {
            if ($this->reflections[$lowerClassName] instanceof \Throwable) {
                throw $this->reflections[$lowerClassName];
            }
            return $this->reflections[$lowerClassName];
        }
        try {
            return $this->reflections[$lowerClassName] = parent::reflect($className);
        } catch (\Throwable $e) {
            $this->reflections[$lowerClassName] = $e;
            throw $e;
        }
    }
}
