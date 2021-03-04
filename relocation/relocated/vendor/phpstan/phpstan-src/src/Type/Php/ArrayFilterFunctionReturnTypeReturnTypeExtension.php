<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class ArrayFilterFunctionReturnTypeReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_filter';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        $callbackArg = $functionCall->args[1]->value ?? null;
        $flagArg = $functionCall->args[2]->value ?? null;
        if ($arrayArg !== null) {
            $arrayArgType = $scope->getType($arrayArg);
            $keyType = $arrayArgType->getIterableKeyType();
            $itemType = $arrayArgType->getIterableValueType();
            if ($arrayArgType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]);
            }
            if ($callbackArg === null) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_map([$this, 'removeFalsey'], \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getArrays($arrayArgType)));
            }
            if ($flagArg === null) {
                $var = null;
                $expr = null;
                if ($callbackArg instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure && \count($callbackArg->stmts) === 1 && \count($callbackArg->params) > 0) {
                    $statement = $callbackArg->stmts[0];
                    if ($statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_ && $statement->expr !== null) {
                        $var = $callbackArg->params[0]->var;
                        $expr = $statement->expr;
                    }
                } elseif ($callbackArg instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction && \count($callbackArg->params) > 0) {
                    $var = $callbackArg->params[0]->var;
                    $expr = $callbackArg->expr;
                }
                if ($var !== null && $expr !== null) {
                    if (!$var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($var->name)) {
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                    }
                    $itemVariableName = $var->name;
                    if (!$scope instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope) {
                        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                    }
                    $scope = $scope->assignVariable($itemVariableName, $itemType);
                    $scope = $scope->filterByTruthyValue($expr);
                    $itemType = $scope->getVariableType($itemVariableName);
                }
            }
        } else {
            $keyType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
            $itemType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($keyType, $itemType);
    }
    public function removeFalsey(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $falseyTypes = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticTypeFactory::falsey();
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            $keys = $type->getKeyTypes();
            $values = $type->getValueTypes();
            $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($values as $offset => $value) {
                $isFalsey = $falseyTypes->isSuperTypeOf($value);
                if ($isFalsey->maybe()) {
                    $builder->setOffsetValueType($keys[$offset], \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove($value, $falseyTypes), \true);
                } elseif ($isFalsey->no()) {
                    $builder->setOffsetValueType($keys[$offset], $value);
                }
            }
            return $builder->getArray();
        }
        $keyType = $type->getIterableKeyType();
        $valueType = $type->getIterableValueType();
        $valueType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove($valueType, $falseyTypes);
        if ($valueType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], []);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($keyType, $valueType);
    }
}
