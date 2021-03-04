<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class FunctionVariantWithPhpDocs extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorWithPhpDocs
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType;
    /**
     * @param TemplateTypeMap $templateTypeMap
     * @param array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs> $parameters
     * @param bool $isVariadic
     * @param Type $returnType
     * @param Type $phpDocReturnType
     * @param Type $nativeReturnType
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap, array $parameters, bool $isVariadic, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $nativeReturnType)
    {
        parent::__construct($templateTypeMap, $resolvedTemplateTypeMap, $parameters, $isVariadic, $returnType);
        $this->phpDocReturnType = $phpDocReturnType;
        $this->nativeReturnType = $nativeReturnType;
    }
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflectionWithPhpDocs>
     */
    public function getParameters() : array
    {
        /** @var \PHPStan\Reflection\ParameterReflectionWithPhpDocs[] $parameters */
        $parameters = parent::getParameters();
        return $parameters;
    }
    public function getPhpDocReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->phpDocReturnType;
    }
    public function getNativeReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->nativeReturnType;
    }
}
