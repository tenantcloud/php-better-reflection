<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class GenericParametersAcceptorResolver
{
    /**
     * Resolve template types
     *
     * @param \PHPStan\Type\Type[] $argTypes Unpacked arguments
     */
    public static function resolve(array $argTypes, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
    {
        $typeMap = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptor->getParameters() as $i => $param) {
            if (isset($argTypes[$i])) {
                $argType = $argTypes[$i];
            } elseif ($param->getDefaultValue() !== null) {
                $argType = $param->getDefaultValue();
            } else {
                break;
            }
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedFunctionVariant($parametersAcceptor, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap(\array_merge($parametersAcceptor->getTemplateTypeMap()->map(static function (string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        })->getTypes(), $typeMap->getTypes())));
    }
}
