<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class MethodTag
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType;
    private bool $isStatic;
    /** @var array<string, \PHPStan\PhpDoc\Tag\MethodTagParameter> */
    private array $parameters;
    /**
     * @param \PHPStan\Type\Type $returnType
     * @param bool $isStatic
     * @param array<string, \PHPStan\PhpDoc\Tag\MethodTagParameter> $parameters
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType, bool $isStatic, array $parameters)
    {
        $this->returnType = $returnType;
        $this->isStatic = $isStatic;
        $this->parameters = $parameters;
    }
    public function getReturnType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function isStatic() : bool
    {
        return $this->isStatic;
    }
    /**
     * @return array<string, \PHPStan\PhpDoc\Tag\MethodTagParameter>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
}
