<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class FunctionSignature
{
    /** @var \PHPStan\Reflection\SignatureMap\ParameterSignature[] */
    private array $parameters;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType;
    private bool $variadic;
    /**
     * @param array<int, \PHPStan\Reflection\SignatureMap\ParameterSignature> $parameters
     * @param \PHPStan\Type\Type $returnType
     * @param \PHPStan\Type\Type $nativeReturnType
     * @param bool $variadic
     */
    public function __construct(array $parameters, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType, bool $variadic)
    {
        $this->parameters = $parameters;
        $this->returnType = $returnType;
        $this->nativeReturnType = $nativeReturnType;
        $this->variadic = $variadic;
    }
    /**
     * @return array<int, \PHPStan\Reflection\SignatureMap\ParameterSignature>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
    public function getReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function getNativeReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->nativeReturnType;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
}
