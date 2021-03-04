<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class StrictComparisonOfDifferentTypesRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private bool $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return [];
        }
        $nodeType = $scope->getType($node);
        if (!$nodeType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $leftType = $scope->getType($node->left);
        $rightType = $scope->getType($node->right);
        if (!$nodeType->getValue()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to false.', $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->build()];
        } elseif ($this->checkAlwaysTrueStrictComparison) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to true.', $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
