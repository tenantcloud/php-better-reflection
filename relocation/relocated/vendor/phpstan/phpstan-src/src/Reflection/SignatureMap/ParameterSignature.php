<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\SignatureMap;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ParameterSignature
{
    private string $name;
    private bool $optional;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference;
    private bool $variadic;
    public function __construct(string $name, bool $optional, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeType, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->type = $type;
        $this->nativeType = $nativeType;
        $this->passedByReference = $passedByReference;
        $this->variadic = $variadic;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function isOptional() : bool
    {
        return $this->optional;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getNativeType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->nativeType;
    }
    public function passedByReference() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
}
