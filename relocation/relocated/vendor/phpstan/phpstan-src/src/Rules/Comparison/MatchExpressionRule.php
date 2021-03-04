<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\MatchExpressionNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<MatchExpressionNode>
 */
class MatchExpressionRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private bool $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\MatchExpressionNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $matchCondition = $node->getCondition();
        $nextArmIsDead = \false;
        $errors = [];
        $armsCount = \count($node->getArms());
        $hasDefault = \false;
        foreach ($node->getArms() as $i => $arm) {
            if ($nextArmIsDead) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Match arm is unreachable because previous comparison is always true.')->line($arm->getLine())->build();
                continue;
            }
            $armConditions = $arm->getConditions();
            if (\count($armConditions) === 0) {
                $hasDefault = \true;
            }
            foreach ($armConditions as $armCondition) {
                $armConditionScope = $armCondition->getScope();
                $armConditionExpr = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($matchCondition, $armCondition->getCondition());
                $armConditionResult = $armConditionScope->getType($armConditionExpr);
                if (!$armConditionResult instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
                    continue;
                }
                $armLine = $armCondition->getLine();
                if (!$armConditionResult->getValue()) {
                    $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always false.', $armConditionScope->getType($matchCondition)->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                } else {
                    $nextArmIsDead = \true;
                    if ($this->checkAlwaysTrueStrictComparison && ($i !== $armsCount - 1 || $i === 0)) {
                        $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match arm comparison between %s and %s is always true.', $armConditionScope->getType($matchCondition)->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value()), $armConditionScope->getType($armCondition->getCondition())->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->line($armLine)->build();
                    }
                }
            }
        }
        if (!$hasDefault && !$nextArmIsDead) {
            $remainingType = $node->getEndScope()->getType($matchCondition);
            if (!$remainingType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
                $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Match expression does not handle remaining %s: %s', $remainingType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType ? 'values' : 'value', $remainingType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value())))->build();
            }
        }
        return $errors;
    }
}
