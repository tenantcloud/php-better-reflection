<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\BetterReflection\Reflector;

use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector;
final class MemoizingFunctionReflector extends \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\FunctionReflector
{
    /** @var array<string, \PHPStan\BetterReflection\Reflection\ReflectionFunction|\Throwable> */
    private array $reflections = [];
    /**
     * Create a ReflectionFunction for the specified $functionName.
     *
     * @return \PHPStan\BetterReflection\Reflection\ReflectionFunction
     *
     * @throws \PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound
     */
    public function reflect(string $functionName) : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection
    {
        $lowerFunctionName = \strtolower($functionName);
        if (isset($this->reflections[$lowerFunctionName])) {
            if ($this->reflections[$lowerFunctionName] instanceof \Throwable) {
                throw $this->reflections[$lowerFunctionName];
            }
            return $this->reflections[$lowerFunctionName];
        }
        try {
            return $this->reflections[$lowerFunctionName] = parent::reflect($functionName);
        } catch (\Throwable $e) {
            $this->reflections[$lowerFunctionName] = $e;
            throw $e;
        }
    }
}
