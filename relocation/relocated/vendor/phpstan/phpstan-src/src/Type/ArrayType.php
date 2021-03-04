<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\MaybeCallableTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\NonObjectTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedBooleanTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ArrayType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
{
    use MaybeCallableTypeTrait;
    use NonObjectTypeTrait;
    use UndecidedBooleanTypeTrait;
    use UndecidedComparisonTypeTrait;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $keyType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $itemType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $keyType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $itemType)
    {
        if ($keyType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()) === '(int|string)') {
            $keyType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
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
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            $result = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            $thisKeyType = $this->keyType;
            $itemType = $this->getItemType();
            foreach ($type->getKeyTypes() as $i => $keyType) {
                $valueType = $type->getValueTypes()[$i];
                $result = $result->and($thisKeyType->accepts($keyType, $strictTypes))->and($itemType->accepts($valueType, $strictTypes));
            }
            return $result;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
            return $this->getItemType()->accepts($type->getItemType(), $strictTypes)->and($this->keyType->accepts($type->keyType, $strictTypes));
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getItemType()->isSuperTypeOf($type->getItemType())->and($this->keyType->isSuperTypeOf($type->keyType));
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType && $this->getItemType()->equals($type->getItemType()) && $this->keyType->equals($type->keyType);
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        $isMixedKeyType = $this->keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && $this->keyType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $isMixedItemType = $this->itemType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && $this->itemType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()) === 'mixed';
        $valueHandler = function () use($level, $isMixedKeyType, $isMixedItemType) : string {
            if ($isMixedKeyType || $this->keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
                if ($isMixedItemType || $this->itemType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
                    return 'array';
                }
                return \sprintf('array<%s>', $this->itemType->describe($level));
            }
            return \sprintf('array<%s, %s>', $this->keyType->describe($level), $this->itemType->describe($level));
        };
        return $level->handle($valueHandler, $valueHandler, function () use($level, $isMixedKeyType, $isMixedItemType) : string {
            if ($isMixedKeyType) {
                if ($isMixedItemType) {
                    return 'array';
                }
                return \sprintf('array<%s>', $this->itemType->describe($level));
            }
            return \sprintf('array<%s, %s>', $this->keyType->describe($level), $this->itemType->describe($level));
        });
    }
    public function generalizeValues() : self
    {
        return new self($this->keyType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($this->itemType));
    }
    public function getKeysArray() : self
    {
        return new self(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $this->keyType);
    }
    public function getValuesArray() : self
    {
        return new self(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $this->itemType);
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
        $keyType = $this->keyType;
        if ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]);
        }
        return $keyType;
    }
    public function getIterableValueType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->getItemType();
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $offsetType = self::castToArrayKeyType($offsetType);
        if ($this->getKeyType()->isSuperTypeOf($offsetType)->no()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        $type = $this->getItemType();
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
        return $type;
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType, bool $unionValues = \true) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($offsetType === null) {
            $offsetType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new self(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($this->keyType, self::castToArrayKeyType($offsetType)), $unionValues ? \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($this->itemType, $valueType) : $valueType), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType());
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()->and((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())->isSuperTypeOf($this->itemType));
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor()];
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
        return $this;
    }
    public function count() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(0, null);
    }
    public static function castToArrayKeyType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($offsetType, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, callable $traverse) : Type {
            if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                return $offsetType;
            }
            if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType) {
                /** @var int|string $offsetValue */
                $offsetValue = \key([$offsetType->getValue() => null]);
                return \is_int($offsetValue) ? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($offsetValue) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType($offsetValue);
            }
            if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType) {
                return $offsetType;
            }
            if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType || $offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType || $offsetType->isNumericString()->yes()) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
            }
            if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType) {
                return $offsetType;
            }
            if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
                return $traverse($offsetType);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]);
        });
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType && \count($receivedType->getKeyTypes()) === 0) {
            $keyType = $this->getKeyType();
            $typeMap = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
            if ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                $typeMap = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap([$keyType->getName() => $keyType->getBound()]);
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                $typeMap = $typeMap->union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap([$itemType->getName() => $itemType->getBound()]));
            }
            return $typeMap;
        }
        if ($receivedType->isArray()->yes()) {
            $keyTypeMap = $this->getKeyType()->inferTemplateTypes($receivedType->getIterableKeyType());
            $itemTypeMap = $this->getItemType()->inferTemplateTypes($receivedType->getIterableValueType());
            return $keyTypeMap->union($itemTypeMap);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $keyVariance = $positionVariance;
        $itemVariance = $positionVariance;
        if (!$positionVariance->contravariant()) {
            $keyType = $this->getKeyType();
            if ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                $keyVariance = $keyType->getVariance();
            }
            $itemType = $this->getItemType();
            if ($itemType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                $itemVariance = $itemType->getVariance();
            }
        }
        return \array_merge($this->getKeyType()->getReferencedTemplateTypes($keyVariance), $this->getItemType()->getReferencedTemplateTypes($itemVariance));
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
