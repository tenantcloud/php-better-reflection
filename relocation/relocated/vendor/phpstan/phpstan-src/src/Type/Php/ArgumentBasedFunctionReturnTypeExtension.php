<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class ArgumentBasedFunctionReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var int[] */
    private array $functionNames = ['array_unique' => 0, 'array_change_key_case' => 0, 'array_diff_assoc' => 0, 'array_diff_key' => 0, 'array_diff_uassoc' => 0, 'array_diff_ukey' => 0, 'array_diff' => 0, 'array_udiff_assoc' => 0, 'array_udiff_uassoc' => 0, 'array_udiff' => 0, 'array_intersect_assoc' => 0, 'array_intersect_key' => 0, 'array_intersect_uassoc' => 0, 'array_intersect_ukey' => 0, 'array_intersect' => 0, 'array_uintersect_assoc' => 0, 'array_uintersect_uassoc' => 0, 'array_uintersect' => 0, 'iterator_to_array' => 0];
    public function isFunctionSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return isset($this->functionNames[$functionReflection->getName()]);
    }
    public function getTypeFromFunctionCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection $functionReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall $functionCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $argumentPosition = $this->functionNames[$functionReflection->getName()];
        if (!isset($functionCall->args[$argumentPosition])) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $argument = $functionCall->args[$argumentPosition];
        $argumentType = $scope->getType($argument->value);
        $argumentKeyType = $argumentType->getIterableKeyType();
        $argumentValueType = $argumentType->getIterableValueType();
        if ($argument->unpack) {
            $argumentKeyType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($argumentKeyType);
            $argumentValueType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($argumentValueType->getIterableValueType());
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($argumentKeyType, $argumentValueType);
    }
}
