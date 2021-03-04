<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class NumberComparisonOperatorsConstantConditionRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Greater && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Smaller && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            return [];
        }
        $exprType = $scope->getType($node);
        if ($exprType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Comparison operation "%s" between %s and %s is always %s.', $node->getOperatorSigil(), $scope->getType($node->left)->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $scope->getType($node->right)->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $exprType->getValue() ? 'true' : 'false'))->build()];
        }
        return [];
    }
}
