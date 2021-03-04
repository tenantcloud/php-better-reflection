<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class StrictMixedType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType
{
    use UndecidedComparisonCompoundTypeTrait;
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isAcceptedBy(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($acceptingType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$acceptingType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType);
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($type instanceof self);
    }
    public function isSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($otherType instanceof self);
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'mixed';
    }
    public function canAccessProperties() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function hasProperty(string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function hasMethod(string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function hasConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function isIterable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isIterableAtLeastOnce() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getIterableKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this;
    }
    public function getIterableValueType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getCallableParametersAcceptors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [];
    }
    public function isCloneable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
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
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [];
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self();
    }
}
