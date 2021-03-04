<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap;

interface SignatureMapProvider
{
    public function hasMethodSignature(string $className, string $methodName, int $variant = 0) : bool;
    public function hasFunctionSignature(string $name, int $variant = 0) : bool;
    public function getMethodSignature(string $className, string $methodName, ?\ReflectionMethod $reflectionMethod, int $variant = 0) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignature;
    public function getFunctionSignature(string $functionName, ?string $className, int $variant = 0) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap\FunctionSignature;
    public function hasMethodMetadata(string $className, string $methodName) : bool;
    public function hasFunctionMetadata(string $name) : bool;
    /**
     * @param string $className
     * @param string $methodName
     * @return array{hasSideEffects: bool}
     */
    public function getMethodMetadata(string $className, string $methodName) : array;
    /**
     * @param string $functionName
     * @return array{hasSideEffects: bool}
     */
    public function getFunctionMetadata(string $functionName) : array;
}
