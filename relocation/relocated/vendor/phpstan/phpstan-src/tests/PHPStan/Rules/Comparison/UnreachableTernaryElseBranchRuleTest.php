<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<UnreachableTernaryElseBranchRule>
 */
class UnreachableTernaryElseBranchRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\UnreachableTernaryElseBranchRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ConstantConditionRuleHelper(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper($this->createReflectionProvider(), $this->getTypeSpecifier(), [], $this->treatPhpDocTypesAsCertain), $this->treatPhpDocTypesAsCertain), $this->treatPhpDocTypesAsCertain);
    }
    protected function shouldTreatPhpDocTypesAsCertain() : bool
    {
        return $this->treatPhpDocTypesAsCertain;
    }
    public function testRule() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/unreachable-ternary-else-branch.php'], [['Else branch is unreachable because ternary operator condition is always true.', 6], ['Else branch is unreachable because ternary operator condition is always true.', 9]]);
    }
    public function testDoNotReportPhpDoc() : void
    {
        $this->treatPhpDocTypesAsCertain = \false;
        $this->analyse([__DIR__ . '/data/unreachable-ternary-else-branch-not-phpdoc.php'], [['Else branch is unreachable because ternary operator condition is always true.', 16], ['Else branch is unreachable because ternary operator condition is always true.', 17]]);
    }
    public function testReportPhpDoc() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $tipText = 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.';
        $this->analyse([__DIR__ . '/data/unreachable-ternary-else-branch-not-phpdoc.php'], [['Else branch is unreachable because ternary operator condition is always true.', 16], ['Else branch is unreachable because ternary operator condition is always true.', 17], ['Else branch is unreachable because ternary operator condition is always true.', 19, $tipText], ['Else branch is unreachable because ternary operator condition is always true.', 20, $tipText]]);
    }
}
