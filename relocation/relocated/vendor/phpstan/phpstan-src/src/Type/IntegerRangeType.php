<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
class IntegerRangeType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType
{
    private ?int $min;
    private ?int $max;
    private function __construct(?int $min, ?int $max)
    {
        \assert($min === null || $max === null || $min <= $max);
        \assert($min !== null || $max !== null);
        $this->min = $min;
        $this->max = $max;
    }
    public static function fromInterval(?int $min, ?int $max, int $shift = 0) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($min !== null && $max !== null) {
            if ($min > $max) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
            }
            if ($min === $max) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($min + $shift);
            }
        }
        if ($min === null && $max === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        return (new self($min, $max))->shift($shift);
    }
    protected static function isDisjoint(?int $minA, ?int $maxA, ?int $minB, ?int $maxB, bool $touchingIsDisjoint = \true) : bool
    {
        $offset = $touchingIsDisjoint ? 0 : 1;
        return $minA !== null && $maxB !== null && $minA > $maxB + $offset || $maxA !== null && $minB !== null && $maxA + $offset < $minB;
    }
    /**
     * Return the range of integers smaller than the given value
     *
     * @param int|float $value
     * @return Type
     */
    public static function createAllSmallerThan($value) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\is_int($value)) {
            return self::fromInterval(null, $value, -1);
        }
        if ($value > \PHP_INT_MAX) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        if ($value <= \PHP_INT_MIN) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        }
        return self::fromInterval(null, (int) \ceil($value), -1);
    }
    /**
     * Return the range of integers smaller than or equal to the given value
     *
     * @param int|float $value
     * @return Type
     */
    public static function createAllSmallerThanOrEqualTo($value) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\is_int($value)) {
            return self::fromInterval(null, $value);
        }
        if ($value >= \PHP_INT_MAX) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        if ($value < \PHP_INT_MIN) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        }
        return self::fromInterval(null, (int) \floor($value));
    }
    /**
     * Return the range of integers greater than the given value
     *
     * @param int|float $value
     * @return Type
     */
    public static function createAllGreaterThan($value) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\is_int($value)) {
            return self::fromInterval($value, null, 1);
        }
        if ($value < \PHP_INT_MIN) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        if ($value >= \PHP_INT_MAX) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        }
        return self::fromInterval((int) \floor($value), null, 1);
    }
    /**
     * Return the range of integers greater than or equal to the given value
     *
     * @param int|float $value
     * @return Type
     */
    public static function createAllGreaterThanOrEqualTo($value) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\is_int($value)) {
            return self::fromInterval($value, null);
        }
        if ($value <= \PHP_INT_MIN) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        if ($value > \PHP_INT_MAX) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        }
        return self::fromInterval((int) \ceil($value), null);
    }
    public function getMin() : ?int
    {
        return $this->min;
    }
    public function getMax() : ?int
    {
        return $this->max;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('int<%s, %s>', $this->min ?? 'min', $this->max ?? 'max');
    }
    public function shift(int $amount) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($amount === 0) {
            return $this;
        }
        $min = $this->min;
        $max = $this->max;
        if ($amount < 0) {
            if ($max !== null) {
                if ($max < \PHP_INT_MIN - $amount) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
                }
                $max += $amount;
            }
            if ($min !== null) {
                $min = $min < \PHP_INT_MIN - $amount ? null : $min + $amount;
            }
        } else {
            if ($min !== null) {
                if ($min > \PHP_INT_MAX - $amount) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
                }
                $min += $amount;
            }
            if ($max !== null) {
                $max = $max > \PHP_INT_MAX - $amount ? null : $max + $amount;
            }
        }
        return self::fromInterval($min, $max);
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof parent) {
            return $this->isSuperTypeOf($type);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof self || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($type instanceof self) {
                $typeMin = $type->min;
                $typeMax = $type->max;
            } else {
                $typeMin = $type->getValue();
                $typeMax = $type->getValue();
            }
            if (self::isDisjoint($this->min, $this->max, $typeMin, $typeMax)) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
            if (($this->min === null || $typeMin !== null && $this->min <= $typeMin) && ($this->max === null || $typeMax !== null && $this->max >= $typeMax)) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof parent) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof parent) {
            return $otherType->isSuperTypeOf($this);
        }
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isAcceptedBy(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->min === $type->min && $this->max === $type->max;
    }
    public function generalize() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new parent();
    }
    public function isSmallerThan(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($this->min === null) {
            $minIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        } else {
            $minIsSmaller = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->min))->isSmallerThan($otherType);
        }
        if ($this->max === null) {
            $maxIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        } else {
            $maxIsSmaller = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->max))->isSmallerThan($otherType);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity($minIsSmaller, $maxIsSmaller);
    }
    public function isSmallerThanOrEqual(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($this->min === null) {
            $minIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        } else {
            $minIsSmaller = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->min))->isSmallerThanOrEqual($otherType);
        }
        if ($this->max === null) {
            $maxIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        } else {
            $maxIsSmaller = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->max))->isSmallerThanOrEqual($otherType);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity($minIsSmaller, $maxIsSmaller);
    }
    public function isGreaterThan(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($this->min === null) {
            $minIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        } else {
            $minIsSmaller = $otherType->isSmallerThan(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->min));
        }
        if ($this->max === null) {
            $maxIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        } else {
            $maxIsSmaller = $otherType->isSmallerThan(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->max));
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity($minIsSmaller, $maxIsSmaller);
    }
    public function isGreaterThanOrEqual(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($this->min === null) {
            $minIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        } else {
            $minIsSmaller = $otherType->isSmallerThanOrEqual(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->min));
        }
        if ($this->max === null) {
            $maxIsSmaller = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        } else {
            $maxIsSmaller = $otherType->isSmallerThanOrEqual(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($this->max));
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity($minIsSmaller, $maxIsSmaller);
    }
    public function getSmallerType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true)];
        if ($this->max !== null) {
            $subtractedTypes[] = self::createAllGreaterThanOrEqualTo($this->max);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getSmallerOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [];
        if ($this->max !== null) {
            $subtractedTypes[] = self::createAllGreaterThan($this->max);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getGreaterType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)];
        if ($this->min !== null) {
            $subtractedTypes[] = self::createAllSmallerThanOrEqualTo($this->min);
        }
        if ($this->min !== null && $this->min > 0 || $this->max !== null && $this->max < 0) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getGreaterOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [];
        if ($this->min !== null) {
            $subtractedTypes[] = self::createAllSmallerThan($this->min);
        }
        if ($this->min !== null && $this->min > 0 || $this->max !== null && $this->max < 0) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new parent();
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        $isZero = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0))->isSuperTypeOf($this);
        if ($isZero->no()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        if ($isZero->maybe()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    /**
     * Return the union with another type, but only if it can be expressed in a simpler way than using UnionType
     *
     * @param Type $otherType
     * @return Type|null
     */
    public function tryUnion(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($otherType instanceof self || $otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($otherType instanceof self) {
                $otherMin = $otherType->min;
                $otherMax = $otherType->max;
            } else {
                $otherMin = $otherType->getValue();
                $otherMax = $otherType->getValue();
            }
            if (self::isDisjoint($this->min, $this->max, $otherMin, $otherMax, \false)) {
                return null;
            }
            return self::fromInterval($this->min !== null && $otherMin !== null ? \min($this->min, $otherMin) : null, $this->max !== null && $otherMax !== null ? \max($this->max, $otherMax) : null);
        }
        if (\get_class($otherType) === parent::class) {
            return $otherType;
        }
        return null;
    }
    /**
     * Return the intersection with another type, but only if it can be expressed in a simpler way than using
     * IntersectionType
     *
     * @param Type $otherType
     * @return Type|null
     */
    public function tryIntersect(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($otherType instanceof self || $otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($otherType instanceof self) {
                $otherMin = $otherType->min;
                $otherMax = $otherType->max;
            } else {
                $otherMin = $otherType->getValue();
                $otherMax = $otherType->getValue();
            }
            if (self::isDisjoint($this->min, $this->max, $otherMin, $otherMax, \false)) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
            }
            if ($this->min === null) {
                $newMin = $otherMin;
            } elseif ($otherMin === null) {
                $newMin = $this->min;
            } else {
                $newMin = \max($this->min, $otherMin);
            }
            if ($this->max === null) {
                $newMax = $otherMax;
            } elseif ($otherMax === null) {
                $newMax = $this->max;
            } else {
                $newMax = \min($this->max, $otherMax);
            }
            return self::fromInterval($newMin, $newMax);
        }
        if (\get_class($otherType) === parent::class) {
            return $this;
        }
        return null;
    }
    /**
     * Return the different with another type, or null if it cannot be represented.
     *
     * @param Type $typeToRemove
     * @return Type|null
     */
    public function tryRemove(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $typeToRemove) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\get_class($typeToRemove) === parent::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
        }
        if ($typeToRemove instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType || $typeToRemove instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($typeToRemove instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType) {
                $removeMin = $typeToRemove->min;
                $removeMax = $typeToRemove->max;
            } else {
                $removeMin = $typeToRemove->getValue();
                $removeMax = $typeToRemove->getValue();
            }
            if ($this->min !== null && $removeMax !== null && $removeMax < $this->min || $this->max !== null && $removeMin !== null && $this->max < $removeMin) {
                return $this;
            }
            if ($removeMin !== null && $removeMin !== \PHP_INT_MIN) {
                $lowerPart = self::fromInterval($this->min, $removeMin - 1);
            } else {
                $lowerPart = null;
            }
            if ($removeMax !== null && $removeMax !== \PHP_INT_MAX) {
                $upperPart = self::fromInterval($removeMax + 1, $this->max);
            } else {
                $upperPart = null;
            }
            if ($lowerPart !== null && $upperPart !== null) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($lowerPart, $upperPart);
            }
            return $lowerPart ?? $upperPart;
        }
        return null;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['min'], $properties['max']);
    }
}
