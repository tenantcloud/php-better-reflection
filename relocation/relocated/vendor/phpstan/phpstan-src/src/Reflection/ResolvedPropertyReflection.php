<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ResolvedPropertyReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $reflection;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $readableType = null;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $writableType = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $reflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap)
    {
        $this->reflection = $reflection;
        $this->templateTypeMap = $templateTypeMap;
    }
    public function getOriginalReflection() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->reflection;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function getDeclaringTrait() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        if ($this->reflection instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection) {
            return $this->reflection->getDeclaringTrait();
        }
        return null;
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    public function getReadableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->readableType;
        if ($type !== null) {
            return $type;
        }
        $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->reflection->getReadableType(), $this->templateTypeMap);
        $this->readableType = $type;
        return $type;
    }
    public function getWritableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->writableType;
        if ($type !== null) {
            return $type;
        }
        $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->reflection->getWritableType(), $this->templateTypeMap);
        $this->writableType = $type;
        return $type;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return $this->reflection->canChangeTypeAfterAssignment();
    }
    public function isReadable() : bool
    {
        return $this->reflection->isReadable();
    }
    public function isWritable() : bool
    {
        return $this->reflection->isWritable();
    }
    public function getDocComment() : ?string
    {
        return $this->reflection->getDocComment();
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
}
