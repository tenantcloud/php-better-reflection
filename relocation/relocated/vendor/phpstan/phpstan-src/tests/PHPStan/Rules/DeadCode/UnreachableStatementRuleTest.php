<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<UnreachableStatementRule>
 */
class UnreachableStatementRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode\UnreachableStatementRule();
    }
    protected function shouldTreatPhpDocTypesAsCertain() : bool
    {
        return $this->treatPhpDocTypesAsCertain;
    }
    public function testRule() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/unreachable.php'], [['Unreachable statement - code above always terminates.', 12], ['Unreachable statement - code above always terminates.', 19], ['Unreachable statement - code above always terminates.', 30], ['Unreachable statement - code above always terminates.', 71]]);
    }
    public function testRuleTopLevel() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/unreachable-top-level.php'], [['Unreachable statement - code above always terminates.', 5]]);
    }
    public function dataBugWithoutGitHubIssue1() : array
    {
        return [[\true], [\false]];
    }
    /**
     * @dataProvider dataBugWithoutGitHubIssue1
     * @param bool $treatPhpDocTypesAsCertain
     */
    public function testBugWithoutGitHubIssue1(bool $treatPhpDocTypesAsCertain) : void
    {
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
        $this->analyse([__DIR__ . '/data/bug-without-issue-1.php'], []);
    }
    public function testBug4070() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/bug-4070.php'], []);
    }
    public function testBug4070Two() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/bug-4070_2.php'], []);
    }
    public function testBug4076() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/bug-4076.php'], []);
    }
    public function testBug4535() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/bug-4535.php'], []);
    }
    public function testBug4346() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/bug-4346.php'], []);
    }
    public function testBug2913() : void
    {
        $this->treatPhpDocTypesAsCertain = \true;
        $this->analyse([__DIR__ . '/data/bug-2913.php'], []);
    }
}
