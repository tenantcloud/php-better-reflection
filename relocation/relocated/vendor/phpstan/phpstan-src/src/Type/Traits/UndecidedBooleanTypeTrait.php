<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
trait UndecidedBooleanTypeTrait
{
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
    }
}
