<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidUnaryOperationRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryPlus && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryMinus && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BitwiseNot) {
            return [];
        }
        if ($scope->getType($node) instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryPlus) {
                $operator = '+';
            } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\UnaryMinus) {
                $operator = '-';
            } else {
                $operator = '~';
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Unary operation "%s" on %s results in an error.', $operator, $scope->getType($node->expr)->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
