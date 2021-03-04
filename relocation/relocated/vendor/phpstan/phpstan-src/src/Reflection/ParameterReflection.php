<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface ParameterReflection
{
    public function getName() : string;
    public function isOptional() : bool;
    public function getType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function passedByReference() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
    public function isVariadic() : bool;
    public function getDefaultValue() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
