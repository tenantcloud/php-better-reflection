<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
final class ArraySearchFunctionDynamicReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_search';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount < 2) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $haystackArgType = $scope->getType($functionCall->args[1]->value);
        $haystackIsArray = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()))->isSuperTypeOf($haystackArgType);
        if ($haystackIsArray->no()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        if ($argsCount < 3) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        $strictArgType = $scope->getType($functionCall->args[2]->value);
        if (!$strictArgType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType());
        } elseif ($strictArgType->getValue() === \false) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        $needleArgType = $scope->getType($functionCall->args[0]->value);
        if ($haystackArgType->getIterableValueType()->isSuperTypeOf($needleArgType)->no()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $typesFromConstantArrays = [];
        if ($haystackIsArray->maybe()) {
            $typesFromConstantArrays[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        }
        $haystackArrays = $this->pickArrays($haystackArgType);
        if (\count($haystackArrays) === 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $arrays = [];
        $typesFromConstantArraysCount = 0;
        foreach ($haystackArrays as $haystackArray) {
            if (!$haystackArray instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                $arrays[] = $haystackArray;
                continue;
            }
            $typesFromConstantArrays[] = $this->resolveTypeFromConstantHaystackAndNeedle($needleArgType, $haystackArray);
            $typesFromConstantArraysCount++;
        }
        if ($typesFromConstantArraysCount > 0 && \count($haystackArrays) === $typesFromConstantArraysCount) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$typesFromConstantArrays);
        }
        $iterableKeyType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$arrays)->getIterableKeyType();
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($iterableKeyType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), ...$typesFromConstantArrays);
    }
    private function resolveTypeFromConstantHaystackAndNeedle(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $needle, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType $haystack) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $matchesByType = [];
        foreach ($haystack->getValueTypes() as $index => $valueType) {
            $isNeedleSuperType = $valueType->isSuperTypeOf($needle);
            if ($isNeedleSuperType->no()) {
                $matchesByType[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
                continue;
            }
            if ($needle instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && $valueType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType && $needle->getValue() === $valueType->getValue()) {
                return $haystack->getKeyTypes()[$index];
            }
            $matchesByType[] = $haystack->getKeyTypes()[$index];
            if (!$isNeedleSuperType->maybe()) {
                continue;
            }
            $matchesByType[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        if (\count($matchesByType) > 0) {
            if ($haystack->getIterableValueType()->accepts($needle, \true)->yes() && $needle->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType())->no()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$matchesByType);
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), ...$matchesByType);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    /**
     * @param Type $type
     * @return Type[]
     */
    private function pickArrays(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
            return [$type];
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            $arrayTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                    continue;
                }
                $arrayTypes[] = $innerType;
            }
            return $arrayTypes;
        }
        return [];
    }
}
