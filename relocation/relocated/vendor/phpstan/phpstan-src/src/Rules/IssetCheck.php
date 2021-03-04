<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyDescriptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class IssetCheck
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyDescriptor $propertyDescriptor, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder)
    {
        $this->propertyDescriptor = $propertyDescriptor;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
    }
    public function check(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, string $operatorDescription, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError $error = null) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
    {
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable && \is_string($expr->name)) {
            $hasVariable = $scope->hasVariableType($expr->name);
            if ($hasVariable->maybe()) {
                return null;
            }
            return $error;
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch && $expr->dim !== null) {
            $type = $scope->getType($expr->var);
            $dimType = $scope->getType($expr->dim);
            $hasOffsetValue = $type->hasOffsetValueType($dimType);
            if (!$type->isOffsetAccessible()->yes()) {
                return $error;
            }
            if ($hasOffsetValue->no()) {
                return $error ?? \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Offset %s on %s %s does not exist.', $dimType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $operatorDescription))->build();
            }
            if ($hasOffsetValue->maybe()) {
                return null;
            }
            // If offset is cannot be null, store this error message and see if one of the earlier offsets is.
            // E.g. $array['a']['b']['c'] ?? null; is a valid coalesce if a OR b or C might be null.
            if ($hasOffsetValue->yes()) {
                $error = $error ?? $this->generateError($type->getOffsetValueType($dimType), \sprintf('Offset %s on %s %s always exists and', $dimType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $operatorDescription));
                if ($error !== null) {
                    return $this->check($expr->var, $scope, $operatorDescription, $error);
                }
            }
            // Has offset, it is nullable
            return null;
        } elseif ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
            $propertyReflection = $this->propertyReflectionFinder->findPropertyReflectionFromNode($expr, $scope);
            if ($propertyReflection === null) {
                return null;
            }
            if (!$propertyReflection->isNative()) {
                return null;
            }
            $nativeType = $propertyReflection->getNativeType();
            if (!$nativeType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                if (!$scope->isSpecified($expr)) {
                    return null;
                }
            }
            $propertyDescription = $this->propertyDescriptor->describeProperty($propertyReflection, $expr);
            $propertyType = $propertyReflection->getWritableType();
            $error = $error ?? $this->generateError($propertyReflection->getWritableType(), \sprintf('%s (%s) %s', $propertyDescription, $propertyType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()), $operatorDescription));
            if ($error !== null) {
                if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
                    return $this->check($expr->var, $scope, $operatorDescription, $error);
                }
                if ($expr->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
                    return $this->check($expr->class, $scope, $operatorDescription, $error);
                }
            }
            return $error;
        }
        return $error ?? $this->generateError($scope->getType($expr), \sprintf('Expression %s', $operatorDescription));
    }
    private function generateError(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, string $message) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
    {
        $nullType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        if ($type->equals($nullType)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is always null.', $message))->build();
        }
        if ($type->isSuperTypeOf($nullType)->no()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s is not nullable.', $message))->build();
        }
        return null;
    }
}
