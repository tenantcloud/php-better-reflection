<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ConstantBooleanType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType
{
    use ConstantScalarTypeTrait;
    private bool $value;
    public function __construct(bool $value)
    {
        $this->value = $value;
    }
    public function getValue() : bool
    {
        return $this->value;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $this->value ? 'true' : 'false';
    }
    public function getSmallerType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->value) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::falsey();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
    }
    public function getSmallerOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->value) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::falsey();
    }
    public function getGreaterType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->value) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::truthy();
    }
    public function getGreaterOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->value) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::truthy();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        return $this;
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
    }
    public function toFloat() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType((float) $this->value);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['value']);
    }
}
