<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class ReplaceFunctionsDynamicReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private array $functions = ['preg_replace' => 2, 'preg_replace_callback' => 2, 'preg_replace_callback_array' => 1, 'str_replace' => 2, 'str_ireplace' => 2, 'substr_replace' => 0];
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \array_key_exists($functionReflection->getName(), $this->functions);
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->getPreliminarilyResolvedTypeFromFunctionCall($functionReflection, $functionCall, $scope);
        $possibleTypes = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::containsNull($possibleTypes)) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull($type);
        }
        return $type;
    }
    private function getPreliminarilyResolvedTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $argumentPosition = $this->functions[$functionReflection->getName()];
        if (\count($functionCall->args) <= $argumentPosition) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $subjectArgumentType = $scope->getType($functionCall->args[$argumentPosition]->value);
        $defaultReturnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($subjectArgumentType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $stringType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
        $arrayType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        $isStringSuperType = $stringType->isSuperTypeOf($subjectArgumentType);
        $isArraySuperType = $arrayType->isSuperTypeOf($subjectArgumentType);
        $compareSuperTypes = $isStringSuperType->compareTo($isArraySuperType);
        if ($compareSuperTypes === $isStringSuperType) {
            return $stringType;
        } elseif ($compareSuperTypes === $isArraySuperType) {
            if ($subjectArgumentType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                return $subjectArgumentType->generalizeValues();
            }
            return $subjectArgumentType;
        }
        return $defaultReturnType;
    }
}
