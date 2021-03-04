<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\ConstantNumericComparisonTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ConstantFloatType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType
{
    use ConstantScalarTypeTrait;
    use ConstantScalarToBooleanTrait;
    use ConstantNumericComparisonTypeTrait;
    private float $value;
    public function __construct(float $value)
    {
        $this->value = $value;
    }
    public function getValue() : float
    {
        return $this->value;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'float';
        }, function () : string {
            $formatted = (string) $this->value;
            if (\strpos($formatted, '.') === \false) {
                $formatted .= '.0';
            }
            return $formatted;
        });
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            if (!$this->equals($type)) {
                if ($this->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()) === $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())) {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
                }
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType((string) $this->value);
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType((int) $this->value);
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
