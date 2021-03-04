<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<NumberComparisonOperatorsConstantConditionRule>
 */
class NumberComparisonOperatorsConstantConditionRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\NumberComparisonOperatorsConstantConditionRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/number-comparison-operators.php'], [['Comparison operation "<=" between int<6, max> and 2 is always false.', 7], ['Comparison operation ">" between int<2, 4> and 8 is always false.', 13], ['Comparison operation "<" between int<min, 1> and 5 is always true.', 21]]);
    }
    public function testBug2648() : void
    {
        $this->analyse([__DIR__ . '/data/bug-2648-rule.php'], []);
    }
    public function testBug2648Namespace() : void
    {
        $this->analyse([__DIR__ . '/data/bug-2648-namespace-rule.php'], []);
    }
}
