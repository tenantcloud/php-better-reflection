<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Keywords;

use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ContinueBreakInLoopRule>
 */
class ContinueBreakInLoopRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Keywords\ContinueBreakInLoopRule();
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/continue-break.php'], [['Keyword break used outside of a loop or a switch statement.', 67], ['Keyword break used outside of a loop or a switch statement.', 69], ['Keyword break used outside of a loop or a switch statement.', 77], ['Keyword continue used outside of a loop or a switch statement.', 79], ['Keyword break used outside of a loop or a switch statement.', 87], ['Keyword break used outside of a loop or a switch statement.', 95]]);
    }
}
