<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper;
class PhpParameterReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflectionWithPhpDocs
{
    private \ReflectionParameter $reflection;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type = null;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeType = null;
    private ?string $declaringClassName;
    public function __construct(\ReflectionParameter $reflection, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType, ?string $declaringClassName)
    {
        $this->reflection = $reflection;
        $this->phpDocType = $phpDocType;
        $this->declaringClassName = $declaringClassName;
    }
    public function isOptional() : bool
    {
        return $this->reflection->isOptional();
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null) {
                try {
                    if ($this->reflection->isDefaultValueAvailable() && $this->reflection->getDefaultValue() === null) {
                        $phpDocType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                    }
                } catch (\Throwable $e) {
                    // pass
                }
            }
            $this->type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), $phpDocType, $this->declaringClassName, $this->isVariadic());
        }
        return $this->type;
    }
    public function passedByReference() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference
    {
        return $this->reflection->isPassedByReference() ? \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo();
    }
    public function isVariadic() : bool
    {
        return $this->reflection->isVariadic();
    }
    public function getPhpDocType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->phpDocType !== null) {
            return $this->phpDocType;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->nativeType === null) {
            $this->nativeType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), null, $this->declaringClassName, $this->isVariadic());
        }
        return $this->nativeType;
    }
    public function getDefaultValue() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        try {
            if ($this->reflection->isDefaultValueAvailable()) {
                $defaultValue = $this->reflection->getDefaultValue();
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($defaultValue);
            }
        } catch (\Throwable $e) {
            return null;
        }
        return null;
    }
}
