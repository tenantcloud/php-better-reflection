<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class ArrayMapFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_map';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        $callableType = $scope->getType($functionCall->args[0]->value);
        if (!$callableType->isCallable()->no()) {
            $valueType = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callableType->getCallableParametersAcceptors($scope))->getReturnType();
        }
        $arrayType = $scope->getType($functionCall->args[1]->value);
        $constantArrays = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($arrayType);
        if (\count($constantArrays) > 0) {
            $arrayTypes = [];
            foreach ($constantArrays as $constantArray) {
                $returnedArrayBuilder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                foreach ($constantArray->getKeyTypes() as $keyType) {
                    $returnedArrayBuilder->setOffsetValueType($keyType, $valueType);
                }
                $arrayTypes[] = $returnedArrayBuilder->getArray();
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
        } elseif ($arrayType->isArray()->yes()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($arrayType->getIterableKeyType(), $valueType), ...\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getAccessoryTypes($arrayType));
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $valueType);
    }
}
