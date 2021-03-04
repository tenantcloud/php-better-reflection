<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
class VariableTypeHolder
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $certainty;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->certainty = $certainty;
    }
    public static function createYes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : self
    {
        return new self($type, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes());
    }
    public static function createMaybe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : self
    {
        return new self($type, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
    }
    public function equals(self $other) : bool
    {
        if (!$this->certainty->equals($other->certainty)) {
            return \false;
        }
        return $this->type->equals($other->type);
    }
    public function and(self $other) : self
    {
        if ($this->getType()->equals($other->getType())) {
            $type = $this->getType();
        } else {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($this->getType(), $other->getType());
        }
        return new self($type, $this->getCertainty()->and($other->getCertainty()));
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getCertainty() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
