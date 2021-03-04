<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UnusedFunctionParametersCheck;
/**
 * @extends \PHPStan\Testing\RuleTestCase<UnusedClosureUsesRule>
 */
class UnusedClosureUsesRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\UnusedClosureUsesRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UnusedFunctionParametersCheck($this->createReflectionProvider()));
    }
    public function testUnusedClosureUses() : void
    {
        $this->analyse([__DIR__ . '/data/unused-closure-uses.php'], [['Anonymous function has an unused use $unused.', 3], ['Anonymous function has an unused use $anotherUnused.', 3], ['Anonymous function has an unused use $usedInClosureUse.', 10]]);
    }
}
