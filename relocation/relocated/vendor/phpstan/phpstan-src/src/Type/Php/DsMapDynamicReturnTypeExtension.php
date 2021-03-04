<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Php;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicMethodReturnTypeExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
final class DsMapDynamicReturnTypeExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return 'TenantCloud\\BetterReflection\\Relocated\\Ds\\Map';
    }
    public function isMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get' || $methodReflection->getName() === 'remove';
    }
    public function getTypeFromMethodCall(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $methodCall, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $returnType = $methodReflection->getVariants()[0]->getReturnType();
        if (\count($methodCall->args) > 1) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $methodCall->args, $methodReflection->getVariants())->getReturnType();
        }
        if ($returnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            $types = \array_values(\array_filter($returnType->getTypes(), static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool {
                return !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
            }));
            if (\count($types) === 1) {
                return $types[0];
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$types);
        }
        return $returnType;
    }
}
