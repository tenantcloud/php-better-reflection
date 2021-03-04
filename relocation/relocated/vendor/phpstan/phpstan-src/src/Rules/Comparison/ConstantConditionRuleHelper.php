<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
class ConstantConditionRuleHelper
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper $impossibleCheckTypeHelper;
    private bool $treatPhpDocTypesAsCertain;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper $impossibleCheckTypeHelper, bool $treatPhpDocTypesAsCertain)
    {
        $this->impossibleCheckTypeHelper = $impossibleCheckTypeHelper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function shouldReportAlwaysTrueByDefault(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : bool
    {
        return $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Ternary || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Isset_;
    }
    public function shouldSkip(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Instanceof_ || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BooleanNot || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanOr || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\BooleanAnd || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Ternary || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Isset_ || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Greater || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            // already checked by different rules
            return \true;
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall || $expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall) {
            $isAlways = $this->impossibleCheckTypeHelper->findSpecifiedType($scope, $expr);
            if ($isAlways !== null) {
                return \true;
            }
        }
        return \false;
    }
    public function getBooleanType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        if ($this->shouldSkip($scope, $expr)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        }
        if ($this->treatPhpDocTypesAsCertain) {
            return $scope->getType($expr)->toBoolean();
        }
        return $scope->getNativeType($expr)->toBoolean();
    }
    public function getNativeBooleanType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        if ($this->shouldSkip($scope, $expr)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        }
        return $scope->getNativeType($expr)->toBoolean();
    }
}
