<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class NativeParameterReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection
{
    private string $name;
    private bool $optional;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference;
    private bool $variadic;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue;
    public function __construct(string $name, bool $optional, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->type = $type;
        $this->passedByReference = $passedByReference;
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
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['name'], $properties['optional'], $properties['type'], $properties['passedByReference'], $properties['variadic'], $properties['defaultValue']);
    }
}
