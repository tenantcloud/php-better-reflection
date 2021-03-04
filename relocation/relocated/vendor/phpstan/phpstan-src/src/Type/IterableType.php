<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\MaybeObjectTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class IterableType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType
{
    use MaybeCallableTypeTrait;
    use MaybeObjectTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $keyType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $itemType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $keyType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $itemType)
    {
        $this->keyType = $keyType;
        $this->itemType = $itemType;
    }
    public function getKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getItemType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->itemType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return \array_merge($this->keyType->getReferencedClasses(), $this->getItemType()->getReferencedClasses());
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType && $type->isEmpty()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->isIterable()->yes()) {
            return $this->getIterableValueType()->accepts($type->getIterableValueType(), $strictTypes)->and($this->getIterableKeyType()->accepts($type->getIterableKeyType(), $strictTypes));
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $type->isIterable()->and($this->getIterableValueType()->isSuperTypeOf($type->getIterableValueType()))->and($this->getIterableKeyType()->isSuperTypeOf($type->getIterableKeyType()));
    }
    public function isSuperTypeOfMixed(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $type->isIterable()->and($this->isNestedTypeSuperTypeOf($this->getIterableValueType(), $type->getIterableValueType()))->and($this->isNestedTypeSuperTypeOf($this->getIterableKeyType(), $type->getIterableKeyType()));
    }
    private function isNestedTypeSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $a, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $b) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if (!$a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType || !$b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
            return $a->isSuperTypeOf($b);
        }
        if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType || $b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType) {
            return $a->isSuperTypeOf($b);
        }
        if ($a->isExplicitMixed()) {
            if ($b->isExplicitMixed()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function isSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType || $otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($this->keyType, $this->itemType), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Traversable::class), $this])]));
        }
        if ($otherType instanceof self) {
            $limit = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        } else {
            $limit = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType && $otherType->isEmpty()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return $limit->and($otherType->isIterable(), $otherType->getIterableValueType()->isSuperTypeOf($this->itemType), $otherType->getIterableKeyType()->isSuperTypeOf($this->keyType));
    }
    public function isAcceptedBy(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        return $this->keyType->equals($type->keyType) && $this->itemType->equals($type->itemType);
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$this->keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
        $isMixedItemType = $this->itemType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$this->itemType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
        if ($isMixedKeyType) {
            if ($isMixedItemType) {
                return 'iterable';
            }
            return \sprintf('iterable<%s>', $this->itemType->describe($level));
        }
        return \sprintf('iterable<%s, %s>', $this->keyType->describe($level), $this->itemType->describe($level));
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($this->getIterableKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($this->keyType, $this->getItemType());
    }
    public function isIterable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function isIterableAtLeastOnce() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getIterableKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->keyType;
    }
    public function getIterableValueType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if (!$receivedType->isIterable()->yes()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $keyTypeMap = $this->getIterableKeyType()->inferTemplateTypes($receivedType->getIterableKeyType());
        $valueTypeMap = $this->getIterableValueType()->inferTemplateTypes($receivedType->getIterableValueType());
        return $keyTypeMap->union($valueTypeMap);
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return \array_merge($this->getIterableKeyType()->getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()), $this->getIterableValueType()->getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()));
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $keyType = $cb($this->keyType);
        $itemType = $cb($this->itemType);
        if ($keyType !== $this->keyType || $itemType !== $this->itemType) {
            return new self($keyType, $itemType);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['keyType'], $properties['itemType']);
    }
}
