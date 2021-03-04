<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ClosureUsesThisRule>
 */
class ClosureUsesThisRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\ClosureUsesThisRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/closure-uses-this.php'], [['Anonymous function uses $this assigned to variable $that. Use $this directly in the function body.', 16]]);
    }
}
