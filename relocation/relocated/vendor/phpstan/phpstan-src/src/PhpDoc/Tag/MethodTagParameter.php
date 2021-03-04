<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class MethodTagParameter
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference;
    private bool $isOptional;
    private bool $isVariadic;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference, bool $isOptional, bool $isVariadic, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue)
    {
        $this->type = $type;
        $this->passedByReference = $passedByReference;
        $this->isOptional = $isOptional;
        $this->isVariadic = $isVariadic;
        $this->defaultValue = $defaultValue;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function passedByReference() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isOptional() : bool
    {
        return $this->isOptional;
    }
    public function isVariadic() : bool
    {
        return $this->isVariadic;
    }
    public function getDefaultValue() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
