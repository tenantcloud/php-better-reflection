<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class FoundPropertyReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $originalPropertyReflection;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope;
    private string $propertyName;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $readableType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $writableType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $originalPropertyReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $readableType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $writableType)
    {
        $this->originalPropertyReflection = $originalPropertyReflection;
        $this->scope = $scope;
        $this->propertyName = $propertyName;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->originalPropertyReflection->getDeclaringClass();
    }
    public function getName() : string
    {
        return $this->propertyName;
    }
    public function isStatic() : bool
    {
        return $this->originalPropertyReflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->originalPropertyReflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->originalPropertyReflection->isPublic();
    }
    public function getDocComment() : ?string
    {
        return $this->originalPropertyReflection->getDocComment();
    }
    public function getReadableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->readableType;
    }
    public function getWritableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->writableType;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return $this->originalPropertyReflection->canChangeTypeAfterAssignment();
    }
    public function isReadable() : bool
    {
        return $this->originalPropertyReflection->isReadable();
    }
    public function isWritable() : bool
    {
        return $this->originalPropertyReflection->isWritable();
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->originalPropertyReflection->getDeprecatedDescription();
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->originalPropertyReflection->isInternal();
    }
    public function isNative() : bool
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        return $reflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection;
    }
    public function getNativeType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $reflection = $this->originalPropertyReflection;
        if ($reflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedPropertyReflection) {
            $reflection = $reflection->getOriginalReflection();
        }
        if (!$reflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection) {
            return null;
        }
        return $reflection->getNativeType();
    }
}
