<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
/**
 * @extends \PHPStan\Testing\RuleTestCase<CompactVariablesRule>
 */
class CompactVariablesRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $checkMaybeUndefinedVariables;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables\CompactVariablesRule($this->checkMaybeUndefinedVariables);
    }
    public function testCompactVariables() : void
    {
        $this->checkMaybeUndefinedVariables = \true;
        $this->analyse([__DIR__ . '/data/compact-variables.php'], [['Call to function compact() contains undefined variable $bar.', 22], ['Call to function compact() contains possibly undefined variable $baz.', 23], ['Call to function compact() contains undefined variable $foo.', 29]]);
    }
}
