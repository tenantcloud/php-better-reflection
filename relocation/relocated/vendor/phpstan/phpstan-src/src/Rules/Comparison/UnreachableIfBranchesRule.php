<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\If_>
 */
class UnreachableIfBranchesRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper;
    private bool $treatPhpDocTypesAsCertain;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper, bool $treatPhpDocTypesAsCertain)
    {
        $this->helper = $helper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\If_::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        $condition = $node->cond;
        $conditionType = $scope->getType($condition)->toBoolean();
        $nextBranchIsDead = $conditionType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType && $conditionType->getValue() && $this->helper->shouldSkip($scope, $node->cond) && !$this->helper->shouldReportAlwaysTrueByDefault($node->cond);
        $addTip = function (\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, &$condition) : RuleErrorBuilder {
            if (!$this->treatPhpDocTypesAsCertain) {
                return $ruleErrorBuilder;
            }
            $booleanNativeType = $scope->doNotTreatPhpDocTypesAsCertain()->getType($condition)->toBoolean();
            if ($booleanNativeType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
                return $ruleErrorBuilder;
            }
            return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
        };
        foreach ($node->elseifs as $elseif) {
            if ($nextBranchIsDead) {
                $errors[] = $addTip(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Elseif branch is unreachable because previous condition is always true.')->line($elseif->getLine()))->identifier('deadCode.unreachableElseif')->metadata(['ifDepth' => $node->getAttribute('statementDepth'), 'ifOrder' => $node->getAttribute('statementOrder'), 'depth' => $elseif->getAttribute('statementDepth'), 'order' => $elseif->getAttribute('statementOrder')])->build();
                continue;
            }
            $condition = $elseif->cond;
            $conditionType = $scope->getType($condition)->toBoolean();
            $nextBranchIsDead = $conditionType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType && $conditionType->getValue() && $this->helper->shouldSkip($scope, $elseif->cond) && !$this->helper->shouldReportAlwaysTrueByDefault($elseif->cond);
        }
        if ($node->else !== null && $nextBranchIsDead) {
            $errors[] = $addTip(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Else branch is unreachable because previous condition is always true.'))->line($node->else->getLine())->identifier('deadCode.unreachableElse')->metadata(['ifDepth' => $node->getAttribute('statementDepth'), 'ifOrder' => $node->getAttribute('statementOrder')])->build();
        }
        return $errors;
    }
}
