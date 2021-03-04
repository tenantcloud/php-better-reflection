<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class ArrayMergeFunctionDynamicReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_merge';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (!isset($functionCall->args[0])) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $keyTypes = [];
        $valueTypes = [];
        foreach ($functionCall->args as $arg) {
            $argType = $scope->getType($arg->value);
            if ($arg->unpack) {
                $argType = $argType->getIterableValueType();
                if ($argType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                    foreach ($argType->getTypes() as $innerType) {
                        $argType = $innerType;
                    }
                }
            }
            $keyTypes[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($argType->getIterableKeyType());
            $valueTypes[] = $argType->getIterableValueType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$keyTypes), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$valueTypes));
    }
}
