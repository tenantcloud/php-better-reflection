<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class RandomIntFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'random_int';
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $minType = $scope->getType($functionCall->args[0]->value)->toInteger();
        $maxType = $scope->getType($functionCall->args[1]->value)->toInteger();
        return $this->createRange($minType, $maxType);
    }
    private function createRange(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $minType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $maxType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $minValues = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : ?int {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType) {
                return $type->getMin();
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                return $type->getValue();
            }
            return null;
        }, $minType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType ? $minType->getTypes() : [$minType]);
        $maxValues = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : ?int {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType) {
                return $type->getMax();
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                return $type->getValue();
            }
            return null;
        }, $maxType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType ? $maxType->getTypes() : [$maxType]);
        \assert(\count($minValues) > 0);
        \assert(\count($maxValues) > 0);
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(\in_array(null, $minValues, \true) ? null : \min($minValues), \in_array(null, $maxValues, \true) ? null : \max($maxValues));
    }
}
