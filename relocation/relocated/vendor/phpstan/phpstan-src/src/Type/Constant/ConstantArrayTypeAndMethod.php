<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ConstantArrayTypeAndMethod
{
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    private ?string $method;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $certainty;
    private function __construct(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, ?string $method, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $certainty)
    {
        $this->type = $type;
        $this->method = $method;
        $this->certainty = $certainty;
    }
    public static function createConcrete(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, string $method, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $certainty) : self
    {
        if ($certainty->no()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return new self($type, $method, $certainty);
    }
    public static function createUnknown() : self
    {
        return new self(null, null, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isUnknown() : bool
    {
        return $this->type === null;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->type === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $this->type;
    }
    public function getMethod() : string
    {
        if ($this->method === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $this->method;
    }
    public function getCertainty() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->certainty;
    }
}
