<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Annotations;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class AnnotationMethodReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
{
    private string $name;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType;
    private bool $isStatic;
    /** @var \PHPStan\Reflection\Annotations\AnnotationsMethodParameterReflection[] */
    private array $parameters;
    private bool $isVariadic;
    /** @var FunctionVariant[]|null */
    private ?array $variants = null;
    /**
     * @param string $name
     * @param ClassReflection $declaringClass
     * @param Type $returnType
     * @param \PHPStan\Reflection\Annotations\AnnotationsMethodParameterReflection[] $parameters
     * @param bool $isStatic
     * @param bool $isVariadic
     */
    public function __construct(string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType, array $parameters, bool $isStatic, bool $isVariadic)
    {
        $this->name = $name;
        $this->declaringClass = $declaringClass;
        $this->returnType = $returnType;
        $this->parameters = $parameters;
        $this->isStatic = $isStatic;
        $this->isVariadic = $isVariadic;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function isStatic() : bool
    {
        return $this->isStatic;
    }
    public function isPrivate() : bool
    {
        return \false;
    }
    public function isPublic() : bool
    {
        return \true;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        if ($this->variants === null) {
            $this->variants = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, $this->parameters, $this->isVariadic, $this->returnType)];
        }
        return $this->variants;
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function getThrowType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
