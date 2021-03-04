<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class GetParentClassDynamicFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_parent_class';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $defaultReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            if ($scope->isInTrait()) {
                return $defaultReturnType;
            }
            if ($scope->isInClass()) {
                return $this->findParentClassType($scope->getClassReflection());
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($scope->isInTrait() && \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::findThisType($argType) !== null) {
            return $defaultReturnType;
        }
        $constantStrings = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($argType);
        if (\count($constantStrings) > 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $stringType) : Type {
                return $this->findParentClassNameType($stringType->getValue());
            }, $constantStrings));
        }
        $classNames = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getDirectClassNames($argType);
        if (\count($classNames) > 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_map(function (string $classNames) : Type {
                return $this->findParentClassNameType($classNames);
            }, $classNames));
        }
        return $defaultReturnType;
    }
    private function findParentClassNameType(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        return $this->findParentClassType($this->reflectionProvider->getClass($className));
    }
    private function findParentClassType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $parentClass = $classReflection->getParentClass();
        if ($parentClass === \false) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType($parentClass->getName(), \true);
    }
}
