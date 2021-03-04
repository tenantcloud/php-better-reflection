<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface TemplateType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType
{
    public function getName() : string;
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
    public function getBound() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function toArgument() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
    public function isArgument() : bool;
    public function isValidVariance(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $a, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $b) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
    public function getVariance() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
}
