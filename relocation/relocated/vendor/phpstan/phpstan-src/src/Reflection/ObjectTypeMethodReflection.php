<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
class ObjectTypeMethodReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType $objectType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $reflection;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private ?array $variants = null;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType $objectType, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $reflection)
    {
        $this->objectType = $objectType;
        $this->reflection = $reflection;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    public function getDocComment() : ?string
    {
        return $this->reflection->getDocComment();
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getPrototype() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->reflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        if ($this->variants !== null) {
            return $this->variants;
        }
        $variants = [];
        foreach ($this->reflection->getVariants() as $variant) {
            $variants[] = $this->processVariant($variant);
        }
        $this->variants = $variants;
        return $this->variants;
    }
    private function processVariant(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $acceptor) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), \array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection $parameter) : ParameterReflection {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($parameter->getType(), function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) : Type {
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
                    return $traverse($this->objectType);
                }
                return $traverse($type);
            });
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter($parameter->getName(), $type, $parameter->isOptional(), $parameter->passedByReference(), $parameter->isVariadic(), $parameter->getDefaultValue());
        }, $acceptor->getParameters()), $acceptor->isVariadic(), $acceptor->getReturnType());
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
