<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class TemplateTag
{
    private string $name;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $variance;
    public function __construct(string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $variance)
    {
        $this->name = $name;
        $this->bound = $bound;
        $this->variance = $variance;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getBound() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->bound;
    }
    public function getVariance() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->variance;
    }
}
