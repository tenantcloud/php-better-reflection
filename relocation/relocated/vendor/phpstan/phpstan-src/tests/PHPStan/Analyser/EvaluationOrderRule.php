<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
class EvaluationOrderRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node::class;
    }
    /**
     * @param Node $node
     * @param Scope $scope
     * @return string[]
     */
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && $node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            return [$node->name->toString()];
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_) {
            return [$node->value];
        }
        return [];
    }
}
