<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ResolvedFunctionVariant implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap;
    /** @var ParameterReflection[]|null */
    private ?array $parameters = null;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap)
    {
        $this->parametersAcceptor = $parametersAcceptor;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
    }
    public function getOriginalParametersAcceptor() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
    {
        return $this->parametersAcceptor;
    }
    public function getTemplateTypeMap() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->parametersAcceptor->getTemplateTypeMap();
    }
    public function getResolvedTemplateTypeMap() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        return $this->resolvedTemplateTypeMap;
    }
    public function getParameters() : array
    {
        $parameters = $this->parameters;
        if ($parameters === null) {
            $parameters = \array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection $param) : ParameterReflection {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter($param->getName(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($param->getType(), $this->resolvedTemplateTypeMap), $param->isOptional(), $param->passedByReference(), $param->isVariadic(), $param->getDefaultValue());
            }, $this->parametersAcceptor->getParameters());
            $this->parameters = $parameters;
        }
        return $parameters;
    }
    public function isVariadic() : bool
    {
        return $this->parametersAcceptor->isVariadic();
    }
    public function getReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->returnType;
        if ($type === null) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveTemplateTypes($this->parametersAcceptor->getReturnType(), $this->resolvedTemplateTypeMap);
            $this->returnType = $type;
        }
        return $type;
    }
}
