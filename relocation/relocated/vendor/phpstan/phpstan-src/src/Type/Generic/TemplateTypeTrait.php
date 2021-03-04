<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
trait TemplateTypeTrait
{
    private string $name;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy $strategy;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $variance;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound;
    public function getName() : string
    {
        return $this->name;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope
    {
        return $this->scope;
    }
    public function getBound() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->bound;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        $basicDescription = function () use($level) : string {
            if ($this->bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                $boundDescription = '';
            } else {
                $boundDescription = \sprintf(' of %s', $this->bound->describe($level));
            }
            return \sprintf('%s%s', $this->name, $boundDescription);
        };
        return $level->handle($basicDescription, $basicDescription, function () use($basicDescription) : string {
            return \sprintf('%s (%s, %s)', $basicDescription(), $this->scope->describe(), $this->isArgument() ? 'argument' : 'parameter');
        });
    }
    public function isArgument() : bool
    {
        return $this->strategy->isArgument();
    }
    public function isValidVariance(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $a, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $b) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->variance->isValidVariance($a, $b);
    }
    public function subtract(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this;
    }
    public function getTypeWithoutSubtractedType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this;
    }
    public function changeSubtractedType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this;
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $type->scope->equals($this->scope) && $type->name === $this->name && $this->bound->equals($type);
    }
    public function isAcceptedBy(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->strategy->accepts($this, $type, $strictTypes);
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return $this->getBound()->isSuperTypeOf($type)->and(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $boundClass = \get_class($this->getBound());
        if (!$type instanceof $boundClass && ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType)) {
            return $type->isSuperTypeOf($this);
        }
        if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
            return $type->isSuperTypeOf($this->getBound());
        }
        if ($this->equals($type)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->getBound()->isSuperTypeOf($this->getBound())->no() && $this->getBound()->isSuperTypeOf($type->getBound())->no()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType && $this->getBound()->isSuperTypeOf($receivedType->getBound())->yes()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap([$this->name => $receivedType]);
        }
        if ($this->getBound()->isSuperTypeOf($receivedType)->yes()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap([$this->name => \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::generalizeType($receivedType)]);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeReference($this, $positionVariance)];
    }
    public function getVariance() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->variance;
    }
}
