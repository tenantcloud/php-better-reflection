<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface ParametersAcceptor
{
    public const VARIADIC_FUNCTIONS = ['func_get_args', 'func_get_arg', 'func_num_args'];
    public function getTemplateTypeMap() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
    public function getResolvedTemplateTypeMap() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array;
    public function isVariadic() : bool;
    public function getReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
