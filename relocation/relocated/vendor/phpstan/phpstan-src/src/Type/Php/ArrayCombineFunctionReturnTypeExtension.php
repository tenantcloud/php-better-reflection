<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class ArrayCombineFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_combine';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $firstArg = $functionCall->args[0]->value;
        $secondArg = $functionCall->args[1]->value;
        $keysParamType = $scope->getType($firstArg);
        $valuesParamType = $scope->getType($secondArg);
        if ($keysParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType && $valuesParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            $keyTypes = $keysParamType->getValueTypes();
            $valueTypes = $valuesParamType->getValueTypes();
            if (\count($keyTypes) !== \count($valueTypes)) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            $keyTypes = $this->sanitizeConstantArrayKeyTypes($keyTypes);
            if ($keyTypes !== null) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType($keyTypes, $valueTypes);
            }
        }
        $arrayType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($keysParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType ? $keysParamType->getItemType() : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $valuesParamType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType ? $valuesParamType->getItemType() : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        if ($this->phpVersion->throwsTypeErrorForInternalFunctions()) {
            return $arrayType;
        }
        if ($firstArg instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable && $secondArg instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable && $firstArg->name === $secondArg->name) {
            return $arrayType;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$arrayType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
    }
    /**
     * @param array<int, Type> $types
     *
     * @return array<int, ConstantIntegerType|ConstantStringType>|null
     */
    private function sanitizeConstantArrayKeyTypes(array $types) : ?array
    {
        $sanitizedTypes = [];
        foreach ($types as $type) {
            if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                return null;
            }
            $sanitizedTypes[] = $type;
        }
        return $sanitizedTypes;
    }
}
