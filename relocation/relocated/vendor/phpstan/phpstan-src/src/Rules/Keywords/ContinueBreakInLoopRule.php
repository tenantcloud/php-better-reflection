<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Keywords;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Stmt>
 */
class ContinueBreakInLoopRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Continue_ && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Break_) {
            return [];
        }
        if (!$node->num instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber) {
            $value = 1;
        } else {
            $value = $node->num->value;
        }
        $parent = $node->getAttribute('parent');
        while ($value > 0) {
            if ($parent === null || $parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_ || $parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod || $parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure) {
                return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Keyword %s used outside of a loop or a switch statement.', $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Continue_ ? 'continue' : 'break'))->nonIgnorable()->build()];
            }
            if ($parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\For_ || $parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Foreach_ || $parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Do_ || $parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\While_) {
                $value--;
            }
            if ($parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Case_) {
                $value--;
                $parent = $parent->getAttribute('parent');
                if (!$parent instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Switch_) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
            }
            $parent = $parent->getAttribute('parent');
        }
        return [];
    }
}
