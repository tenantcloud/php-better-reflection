<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr>
 */
class VariableCertaintyNullCoalesceRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $var = $node->var;
            $description = '??=';
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $var = $node->left;
            $description = '??';
        } else {
            return [];
        }
        $isSubNode = \false;
        while ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch || $var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            if ($var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
                $var = $var->class;
            } else {
                $var = $var->var;
            }
            $isSubNode = \true;
        }
        if (!$var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($var->name)) {
            return [];
        }
        $certainty = $scope->hasVariableType($var->name);
        if ($certainty->no()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is never defined.', $var->name, $description))->build()];
        } elseif ($certainty->yes() && !$isSubNode) {
            $variableType = $scope->getVariableType($var->name);
            if ($variableType->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType())->no()) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s always exists and is not nullable.', $var->name, $description))->build()];
            } elseif ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType())->isSuperTypeOf($variableType)->yes()) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is always null.', $var->name, $description))->build()];
            }
        }
        return [];
    }
}
