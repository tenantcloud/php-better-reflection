<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\IssetCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class NullCoalesceRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\IssetCheck $issetCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\IssetCheck $issetCheck)
    {
        $this->issetCheck = $issetCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $error = $this->issetCheck->check($node->left, $scope, 'on left side of ??');
        } elseif ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $error = $this->issetCheck->check($node->var, $scope, 'on left side of ??=');
        } else {
            return [];
        }
        if ($error === null) {
            return [];
        }
        return [$error];
    }
}
