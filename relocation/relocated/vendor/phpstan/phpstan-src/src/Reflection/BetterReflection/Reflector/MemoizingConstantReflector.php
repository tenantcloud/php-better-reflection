<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector;
final class MemoizingConstantReflector extends \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\ConstantReflector
{
    /** @var array<string, \PHPStan\BetterReflection\Reflection\ReflectionConstant|\Throwable> */
    private array $reflections = [];
    /**
     * Create a ReflectionConstant for the specified $constantName.
     *
     * @return \PHPStan\BetterReflection\Reflection\ReflectionConstant
     *
     * @throws \PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound
     */
    public function reflect(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        if (isset($this->reflections[$constantName])) {
            if ($this->reflections[$constantName] instanceof \Throwable) {
                throw $this->reflections[$constantName];
            }
            return $this->reflections[$constantName];
        }
        try {
            return $this->reflections[$constantName] = parent::reflect($constantName);
        } catch (\Throwable $e) {
            $this->reflections[$constantName] = $e;
            throw $e;
        }
    }
}
