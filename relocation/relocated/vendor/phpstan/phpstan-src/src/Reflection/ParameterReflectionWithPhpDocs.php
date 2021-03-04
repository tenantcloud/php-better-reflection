<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function getNativeType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
