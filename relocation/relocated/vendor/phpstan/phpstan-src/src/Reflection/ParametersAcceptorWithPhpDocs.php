<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface ParametersAcceptorWithPhpDocs extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
{
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array;
    public function getPhpDocReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function getNativeReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
