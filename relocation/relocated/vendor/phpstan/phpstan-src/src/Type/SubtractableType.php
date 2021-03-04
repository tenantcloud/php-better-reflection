<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

interface SubtractableType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
{
    public function subtract(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function getTypeWithoutSubtractedType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function changeSubtractedType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function getSubtractedType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
