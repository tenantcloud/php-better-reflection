<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

interface ConstantType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
{
    public function generalize() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
