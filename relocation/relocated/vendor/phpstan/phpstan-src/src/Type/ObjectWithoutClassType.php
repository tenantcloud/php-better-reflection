<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\NonGenericTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\ObjectTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ObjectWithoutClassType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\SubtractableType
{
    use ObjectTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType;
    public function __construct(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType = null)
    {
        if ($subtractedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->subtractedType = $subtractedType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($type instanceof self || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName);
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        if ($type instanceof self) {
            if ($this->subtractedType === null) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            if ($type->subtractedType !== null) {
                $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
                if ($isSuperType->yes()) {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
            if ($this->subtractedType === null) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            return $this->subtractedType->isSuperTypeOf($type)->negate();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if ($this->subtractedType === null) {
            if ($type->subtractedType === null) {
                return \true;
            }
            return \false;
        }
        if ($type->subtractedType === null) {
            return \false;
        }
        return $this->subtractedType->equals($type->subtractedType);
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'object';
        }, static function () : string {
            return 'object';
        }, function () use($level) : string {
            $description = 'object';
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            return $description;
        });
    }
    public function subtract(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($type instanceof self) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        }
        if ($this->subtractedType !== null) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return new self($type);
    }
    public function getTypeWithoutSubtractedType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self();
    }
    public function changeSubtractedType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($subtractedType);
    }
    public function getSubtractedType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedType = $this->subtractedType !== null ? $cb($this->subtractedType) : null;
        if ($subtractedType !== $this->subtractedType) {
            return new self($subtractedType);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['subtractedType'] ?? null);
    }
}
