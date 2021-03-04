<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\IntersectionTypeMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
class IntersectionType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private array $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $this->types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionTypeHelper::sortTypes($types);
    }
    /**
     * @return Type[]
     */
    public function getTypes() : array
    {
        return $this->types;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->types);
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        foreach ($this->types as $type) {
            if (!$type->accepts($otherType, $strictTypes)->yes()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType && $this->equals($otherType)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()->and(...$results);
    }
    public function isSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function isAcceptedBy(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($acceptingType instanceof self || $acceptingType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            return $acceptingType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if (\count($this->types) !== \count($type->types)) {
            return \false;
        }
        foreach ($this->types as $i => $innerType) {
            if (!$innerType->equals($type->types[$i])) {
                return \false;
            }
        }
        return \true;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType) {
                    continue;
                }
                $typeNames[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($type)->describe($level);
            }
            return \implode('&', $typeNames);
        }, function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType) {
                    continue;
                }
                $typeNames[] = $type->describe($level);
            }
            return \implode('&', $typeNames);
        }, function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                $typeNames[] = $type->describe($level);
            }
            return \implode('&', $typeNames);
        });
    }
    public function canAccessProperties() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasProperty($propertyName)->yes()) {
                return $type->getProperty($propertyName, $scope);
            }
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
            return $type->hasMethod($methodName);
        });
    }
    public function getMethod(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $methods = [];
        foreach ($this->types as $type) {
            if (!$type->hasMethod($methodName)->yes()) {
                continue;
            }
            $methods[] = $type->getMethod($methodName, $scope);
        }
        $methodsCount = \count($methods);
        if ($methodsCount === 0) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if ($methodsCount === 1) {
            return $methods[0];
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\IntersectionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasConstant($constantName)->yes()) {
                return $type->getConstant($constantName);
            }
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function isIterable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($offsetType) : Type {
            return $type->getOffsetValueType($offsetType);
        });
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
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
    public function isCloneable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $type->isSmallerThan($otherType);
        });
    }
    public function isSmallerThanOrEqual(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $type->isSmallerThanOrEqual($otherType);
        });
    }
    public function isGreaterThan(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $otherType->isSmallerThan($type);
        });
    }
    public function isGreaterThanOrEqual(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $otherType->isSmallerThanOrEqual($type);
        });
    }
    public function getSmallerType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getSmallerType();
        });
    }
    public function getSmallerOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getSmallerOrEqualType();
        });
    }
    public function getGreaterType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getGreaterType();
        });
    }
    public function getGreaterOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getGreaterOrEqualType();
        });
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        $type = $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        }
        return $type;
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $templateType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($templateType->inferTemplateTypes($type));
        }
        return $types;
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = [];
        foreach ($this->types as $type) {
            foreach ($type->getReferencedTemplateTypes($positionVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $types = [];
        $changed = \false;
        foreach ($this->types as $type) {
            $newType = $cb($type);
            if ($type !== $newType) {
                $changed = \true;
            }
            $types[] = $newType;
        }
        if ($changed) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(...$types);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['types']);
    }
    /**
     * @param callable(Type $type): TrinaryLogic $getResult
     * @return TrinaryLogic
     */
    private function intersectResults(callable $getResult) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $operands = \array_map($getResult, $this->types);
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::maxMin(...$operands);
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    private function intersectTypes(callable $getType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $operands = \array_map($getType, $this->types);
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(...$operands);
    }
}
