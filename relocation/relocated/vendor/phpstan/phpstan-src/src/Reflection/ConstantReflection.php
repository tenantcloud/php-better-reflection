<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

interface ConstantReflection extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection
{
    /**
     * @return mixed
     */
    public function getValue();
}
