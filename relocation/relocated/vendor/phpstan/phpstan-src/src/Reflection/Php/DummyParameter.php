<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class DummyParameter implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection
{
    private string $name;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    private bool $optional;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference;
    private bool $variadic;
    /** @var ?\PHPStan\Type\Type */
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue;
    public function __construct(string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $optional, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue)
    {
        $this->name = $name;
        $this->type = $type;
        $this->optional = $optional;
        $this->passedByReference = $passedByReference ?? \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo();
        $this->variadic = $variadic;
        $this->defaultValue = $defaultValue;
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
    public function passedByReference() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
