<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
class PhpMethodFromParserNodeReflection extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass;
    /**
     * @param ClassReflection $declaringClass
     * @param ClassMethod $classMethod
     * @param TemplateTypeMap $templateTypeMap
     * @param \PHPStan\Type\Type[] $realParameterTypes
     * @param \PHPStan\Type\Type[] $phpDocParameterTypes
     * @param \PHPStan\Type\Type[] $realParameterDefaultValues
     * @param Type $realReturnType
     * @param Type|null $phpDocReturnType
     * @param Type|null $throwType
     * @param string|null $deprecatedDescription
     * @param bool $isDeprecated
     * @param bool $isInternal
     * @param bool $isFinal
     * @param bool|null $isPure
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod $classMethod, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $templateTypeMap, array $realParameterTypes, array $phpDocParameterTypes, array $realParameterDefaultValues, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $realReturnType, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocReturnType, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $throwType, ?string $deprecatedDescription, bool $isDeprecated, bool $isInternal, bool $isFinal, ?bool $isPure = null)
    {
        $name = \strtolower($classMethod->name->name);
        if ($name === '__construct' || $name === '__destruct' || $name === '__unset' || $name === '__wakeup' || $name === '__clone') {
            $realReturnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType();
        }
        if ($name === '__tostring') {
            $realReturnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
        }
        if ($name === '__isset') {
            $realReturnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        }
        if ($name === '__sleep') {
            $realReturnType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType());
        }
        if ($name === '__set_state') {
            $realReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), $realReturnType);
        }
        parent::__construct($classMethod, $templateTypeMap, $realParameterTypes, $phpDocParameterTypes, $realParameterDefaultValues, $realReturnType, $phpDocReturnType, $throwType, $deprecatedDescription, $isDeprecated, $isInternal, $isFinal || $classMethod->isFinal(), $isPure);
        $this->declaringClass = $declaringClass;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function getPrototype() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            return $this->declaringClass->getNativeMethod($this->getClassMethod()->name->name)->getPrototype();
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MissingMethodFromReflectionException $e) {
            return $this;
        }
    }
    private function getClassMethod() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod
    {
        /** @var \PhpParser\Node\Stmt\ClassMethod $functionLike */
        $functionLike = $this->getFunctionLike();
        return $functionLike;
    }
    public function isStatic() : bool
    {
        return $this->getClassMethod()->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->getClassMethod()->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->getClassMethod()->isPublic();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
    public function isBuiltin() : bool
    {
        return \false;
    }
}
