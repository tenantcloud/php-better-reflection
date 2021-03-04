<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidIncDecOperationRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private bool $checkThisOnly;
    public function __construct(bool $checkThisOnly)
    {
        $this->checkThisOnly = $checkThisOnly;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreInc && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostInc && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreDec && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostDec) {
            return [];
        }
        $operatorString = $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PreInc || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PostInc ? '++' : '--';
        if (!$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable && !$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch && !$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot use %s on a non-variable.', $operatorString))->line($node->var->getLine())->build()];
        }
        if (!$this->checkThisOnly) {
            $varType = $scope->getType($node->var);
            if (!$varType->toString() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$varType->toNumber() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                return [];
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot use %s on %s.', $operatorString, $varType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->line($node->var->getLine())->build()];
        }
        return [];
    }
}
