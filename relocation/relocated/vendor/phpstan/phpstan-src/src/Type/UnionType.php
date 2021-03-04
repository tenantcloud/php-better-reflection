<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnionTypeMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
class UnionType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private array $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $throwException = static function () use($types) : void {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Cannot create %s with: %s', self::class, \implode(', ', \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : string {
                return $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value());
            }, $types))));
        };
        if (\count($types) < 2) {
            $throwException();
        }
        foreach ($types as $type) {
            if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                continue;
            }
            $throwException();
        }
        $this->types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionTypeHelper::sortTypes($types);
    }
    /**
     * @return \PHPStan\Type\Type[]
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
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->getTypes());
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->accepts($type, $strictTypes);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType) {
            return $otherType->isSubTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function isAcceptedBy(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof static) {
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
        $joinTypes = static function (array $types) use($level) : string {
            $typeNames = [];
            foreach ($types as $type) {
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType) {
                    $typeNames[] = \sprintf('(%s)', $type->describe($level));
                } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
                    $intersectionDescription = $type->describe($level);
                    if (\strpos($intersectionDescription, '&') !== \false) {
                        $typeNames[] = \sprintf('(%s)', $type->describe($level));
                    } else {
                        $typeNames[] = $intersectionDescription;
                    }
                } else {
                    $typeNames[] = $type->describe($level);
                }
            }
            return \implode('|', $typeNames);
        };
        return $level->handle(function () use($joinTypes) : string {
            $types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
                    return $type->generalize();
                }
                return $type;
            }, $this->types));
            if ($types instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                return $joinTypes($types->getTypes());
            }
            return $joinTypes([$types]);
        }, function () use($joinTypes) : string {
            return $joinTypes($this->types);
        });
    }
    /**
     * @param callable(Type $type): TrinaryLogic $canCallback
     * @param callable(Type $type): TrinaryLogic $hasCallback
     * @return TrinaryLogic
     */
    private function hasInternal(callable $canCallback, callable $hasCallback) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->types as $type) {
            if ($canCallback($type)->no()) {
                $results[] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
                continue;
            }
            $results[] = $hasCallback($type);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    /**
     * @param callable(Type $type): TrinaryLogic $hasCallback
     * @param callable(Type $type): object $getCallback
     * @return object
     */
    private function getInternal(callable $hasCallback, callable $getCallback)
    {
        /** @var TrinaryLogic|null $result */
        $result = null;
        /** @var object|null $object */
        $object = null;
        foreach ($this->types as $type) {
            $has = $hasCallback($type);
            if (!$has->yes()) {
                continue;
            }
            if ($result !== null && $result->compareTo($has) !== $has) {
                continue;
            }
            $get = $getCallback($type);
            $result = $has;
            $object = $get;
        }
        if ($object === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $object;
    }
    public function canAccessProperties() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->getInternal(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        }, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($propertyName, $scope) : PropertyReflection {
            return $type->getProperty($propertyName, $scope);
        });
    }
    public function canCallMethods() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
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
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->hasInternal(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        }, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection
    {
        return $this->getInternal(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        }, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($constantName) : ConstantReflection {
            return $type->getConstant($constantName);
        });
    }
    public function isIterable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $types = [];
        foreach ($this->types as $innerType) {
            $valueType = $innerType->getOffsetValueType($offsetType);
            if ($valueType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                continue;
            }
            $types[] = $valueType;
        }
        if (\count($types) === 0) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$types);
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        foreach ($this->types as $type) {
            if ($type->isCallable()->no()) {
                continue;
            }
            return $type->getCallableParametersAcceptors($scope);
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $type->isSmallerThan($otherType);
        });
    }
    public function isSmallerThanOrEqual(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $type->isSmallerThanOrEqual($otherType);
        });
    }
    public function getSmallerType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getSmallerType();
        });
    }
    public function getSmallerOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getSmallerOrEqualType();
        });
    }
    public function getGreaterType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getGreaterType();
        });
    }
    public function getGreaterOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->getGreaterOrEqualType();
        });
    }
    public function isGreaterThan(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $otherType->isSmallerThan($type);
        });
    }
    public function isGreaterThanOrEqual(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($otherType) : TrinaryLogic {
            return $otherType->isSmallerThanOrEqual($type);
        });
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        /** @var BooleanType $type */
        $type = $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        return $type;
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $templateType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($templateType->inferTemplateTypes($type));
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
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$types);
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
    private function unionResults(callable $getResult) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity(...\array_map($getResult, $this->types));
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    protected function unionTypes(callable $getType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_map($getType, $this->types));
    }
}
