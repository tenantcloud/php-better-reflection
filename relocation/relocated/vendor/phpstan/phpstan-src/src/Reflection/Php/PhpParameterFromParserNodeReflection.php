<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper;
class PhpParameterFromParserNodeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs
{
    private string $name;
    private bool $optional;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $realType;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue;
    private bool $variadic;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type = null;
    public function __construct(string $name, bool $optional, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $realType, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference $passedByReference, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $defaultValue, bool $variadic)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->realType = $realType;
        $this->phpDocType = $phpDocType;
        $this->passedByReference = $passedByReference;
        $this->defaultValue = $defaultValue;
        $this->variadic = $variadic;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function isOptional() : bool
    {
        return $this->optional;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null && $this->defaultValue !== null) {
                if ($this->defaultValue instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType) {
                    $phpDocType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                }
            }
            $this->type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideType($this->realType, $phpDocType);
        }
        return $this->type;
    }
    public function getPhpDocType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->phpDocType ?? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->realType;
    }
    public function passedByReference() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
