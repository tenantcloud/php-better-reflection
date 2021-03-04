<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<Assign>
 */
class ArrayDestructuringRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\NonexistentOffsetInArrayDimFetchCheck $nonexistentOffsetInArrayDimFetchCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\NonexistentOffsetInArrayDimFetchCheck $nonexistentOffsetInArrayDimFetchCheck)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->nonexistentOffsetInArrayDimFetchCheck = $nonexistentOffsetInArrayDimFetchCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Assign::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\List_ && !$node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_) {
            return [];
        }
        return $this->getErrors($scope, $node->var, $node->expr);
    }
    /**
     * @param Node\Expr\List_|Node\Expr\Array_ $var
     * @return RuleError[]
     */
    private function getErrors(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $var, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : array
    {
        $exprTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $varType) : bool {
            return $varType->isArray()->yes();
        });
        $exprType = $exprTypeResult->getType();
        if ($exprType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return [];
        }
        if (!$exprType->isArray()->yes()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot use array destructuring on %s.', $exprType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        $errors = [];
        $i = 0;
        foreach ($var->items as $item) {
            if ($item === null) {
                $i++;
                continue;
            }
            $keyExpr = null;
            if ($item->key === null) {
                $keyType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($i);
                $keyExpr = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber($i);
            } else {
                $keyType = $scope->getType($item->key);
                if ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                    $keyExpr = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber($keyType->getValue());
                } elseif ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                    $keyExpr = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_($keyType->getValue());
                }
            }
            $itemErrors = $this->nonexistentOffsetInArrayDimFetchCheck->check($scope, $expr, '', $keyType);
            $errors = \array_merge($errors, $itemErrors);
            if ($keyExpr === null) {
                $i++;
                continue;
            }
            if (!$item->value instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\List_ && !$item->value instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_) {
                $i++;
                continue;
            }
            $errors = \array_merge($errors, $this->getErrors($scope, $item->value, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch($expr, $keyExpr)));
        }
        return $errors;
    }
}
