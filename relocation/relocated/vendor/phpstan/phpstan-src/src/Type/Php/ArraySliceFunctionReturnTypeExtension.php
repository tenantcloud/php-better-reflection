<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class ArraySliceFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_slice';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        if ($arrayArg === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        }
        $valueType = $scope->getType($arrayArg);
        if (isset($functionCall->args[1])) {
            $offset = $scope->getType($functionCall->args[1]->value);
            if (!$offset instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                $offset = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0);
            }
        } else {
            $offset = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0);
        }
        if (isset($functionCall->args[2])) {
            $limit = $scope->getType($functionCall->args[2]->value);
            if (!$limit instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                $limit = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            }
        } else {
            $limit = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        $constantArrays = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($valueType);
        if (\count($constantArrays) === 0) {
            $arrays = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getArrays($valueType);
            if (\count($arrays) !== 0) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$arrays);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        }
        if (isset($functionCall->args[3])) {
            $preserveKeys = $scope->getType($functionCall->args[3]->value);
            $preserveKeys = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($preserveKeys)->yes();
        } else {
            $preserveKeys = \false;
        }
        $arrayTypes = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType $constantArray) use($offset, $limit, $preserveKeys) : ConstantArrayType {
            return $constantArray->slice($offset->getValue(), $limit->getValue(), $preserveKeys);
        }, $constantArrays);
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
