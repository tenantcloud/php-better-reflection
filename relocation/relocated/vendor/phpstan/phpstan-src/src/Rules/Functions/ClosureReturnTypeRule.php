<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClosureReturnStatementsNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionReturnTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
/**
 * @implements \PHPStan\Rules\Rule<ClosureReturnStatementsNode>
 */
class ClosureReturnTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck)
    {
        $this->returnTypeCheck = $returnTypeCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClosureReturnStatementsNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInAnonymousFunction()) {
            return [];
        }
        /** @var \PHPStan\Type\Type $returnType */
        $returnType = $scope->getAnonymousFunctionReturnType();
        $containsNull = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::containsNull($returnType);
        $hasNativeTypehint = $node->getClosureExpr()->returnType !== null;
        $messages = [];
        foreach ($node->getReturnStatements() as $returnStatement) {
            $returnNode = $returnStatement->getReturnNode();
            $returnExpr = $returnNode->expr;
            if ($returnExpr === null && $containsNull && !$hasNativeTypehint) {
                $returnExpr = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name\FullyQualified('null'));
            }
            $returnMessages = $this->returnTypeCheck->checkReturnType($returnStatement->getScope(), $returnType, $returnExpr, $returnNode, 'Anonymous function should return %s but empty return statement found.', 'Anonymous function with return type void returns %s but should not return anything.', 'Anonymous function should return %s but returns %s.', 'Anonymous function should never return but return statement found.', \count($node->getYieldStatements()) > 0);
            foreach ($returnMessages as $returnMessage) {
                $messages[] = $returnMessage;
            }
        }
        return $messages;
    }
}
