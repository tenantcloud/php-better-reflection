<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class CompactFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private bool $checkMaybeUndefinedVariables;
    public function __construct(bool $checkMaybeUndefinedVariables)
    {
        $this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
    }
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'compact';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $defaultReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            return $defaultReturnType;
        }
        if ($scope->canAnyVariableExist() && !$this->checkMaybeUndefinedVariables) {
            return $defaultReturnType;
        }
        $array = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        foreach ($functionCall->args as $arg) {
            $type = $scope->getType($arg->value);
            $constantStrings = $this->findConstantStrings($type);
            if ($constantStrings === null) {
                return $defaultReturnType;
            }
            foreach ($constantStrings as $constantString) {
                $has = $scope->hasVariableType($constantString->getValue());
                if ($has->no()) {
                    continue;
                }
                $array->setOffsetValueType($constantString, $scope->getVariableType($constantString->getValue()), $has->maybe());
            }
        }
        return $array->getArray();
    }
    /**
     * @param Type $type
     * @return array<int, ConstantStringType>|null
     */
    private function findConstantStrings(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : ?array
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            return [$type];
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            $result = [];
            foreach ($type->getValueTypes() as $valueType) {
                $constantStrings = $this->findConstantStrings($valueType);
                if ($constantStrings === null) {
                    return null;
                }
                $result = \array_merge($result, $constantStrings);
            }
            return $result;
        }
        return null;
    }
}
