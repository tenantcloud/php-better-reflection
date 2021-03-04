<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class GenericClassStringType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getReferencedClasses() : array
    {
        return $this->type->getReferencedClasses();
    }
    public function getGenericType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), $this->type->describe($level));
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getValue())) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
            $objectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($type->getValue());
        } elseif ($type instanceof self) {
            $objectType = $type->type;
        } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType) {
            $objectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        } else {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return $this->type->accepts($objectType, $strictTypes);
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            $genericType = $this->type;
            if ($genericType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            if ($genericType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($type->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Maybe.
            if ($isSuperType->maybe()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
            return $isSuperType;
        } elseif ($type instanceof self) {
            return $this->type->isSuperTypeOf($type->type);
        } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $newType = $cb($this->type);
        if ($newType === $this->type) {
            return $this;
        }
        return new self($newType);
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            $typeToInfer = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($receivedType->getValue());
        } elseif ($receivedType instanceof self) {
            $typeToInfer = $receivedType->type;
        } elseif ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType) {
            $typeToInfer = $this->type;
            if ($typeToInfer instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                $typeToInfer = $typeToInfer->getBound();
            }
            $typeToInfer = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($typeToInfer, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType());
        } else {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        return $this->type->inferTemplateTypes($typeToInfer);
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $variance = $positionVariance->compose(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant());
        return $this->type->getReferencedTemplateTypes($variance);
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if (!parent::equals($type)) {
            return \false;
        }
        if (!$this->type->equals($type->type)) {
            return \false;
        }
        return \true;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['type']);
    }
}
