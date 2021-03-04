<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

class TemplateTypeReference
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType $type;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance)
    {
        $this->type = $type;
        $this->positionVariance = $positionVariance;
    }
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
    {
        return $this->type;
    }
    public function getPositionVariance() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->positionVariance;
    }
}
