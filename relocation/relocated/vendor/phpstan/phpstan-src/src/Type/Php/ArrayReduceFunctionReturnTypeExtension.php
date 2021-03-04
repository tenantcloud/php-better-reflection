<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class ArrayReduceFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_reduce';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (!isset($functionCall->args[1])) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackType = $scope->getType($functionCall->args[1]->value);
        if ($callbackType->isCallable()->no()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callbackType->getCallableParametersAcceptors($scope))->getReturnType();
        if (isset($functionCall->args[2])) {
            $initialType = $scope->getType($functionCall->args[2]->value);
        } else {
            $initialType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        $arraysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($arraysType);
        if (\count($constantArrays) > 0) {
            $onlyEmpty = \true;
            $onlyNonEmpty = \true;
            foreach ($constantArrays as $constantArray) {
                $isEmpty = \count($constantArray->getValueTypes()) === 0;
                $onlyEmpty = $onlyEmpty && $isEmpty;
                $onlyNonEmpty = $onlyNonEmpty && !$isEmpty;
            }
            if ($onlyEmpty) {
                return $initialType;
            }
            if ($onlyNonEmpty) {
                return $callbackReturnType;
            }
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($callbackReturnType, $initialType);
    }
}
