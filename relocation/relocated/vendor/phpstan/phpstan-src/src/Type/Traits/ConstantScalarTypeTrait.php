<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
trait ConstantScalarTypeTrait
{
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($this->value === $type->value);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->value === $type->value ? \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->value === $type->value;
    }
    public function isSmallerThan(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($this->value < $otherType->getValue());
        }
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThan($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isSmallerThanOrEqual(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($this->value <= $otherType->getValue());
        }
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $otherType->isGreaterThanOrEqual($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function generalize() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new parent();
    }
}
