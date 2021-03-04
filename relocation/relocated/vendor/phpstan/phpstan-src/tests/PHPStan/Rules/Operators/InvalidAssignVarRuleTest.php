<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<InvalidAssignVarRule>
 */
class InvalidAssignVarRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators\InvalidAssignVarRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck());
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/invalid-assign-var.php'], [['Nullsafe operator cannot be on left side of assignment.', 12], ['Nullsafe operator cannot be on left side of assignment.', 13], ['Nullsafe operator cannot be on left side of assignment.', 14], ['Nullsafe operator cannot be on left side of assignment.', 16], ['Nullsafe operator cannot be on left side of assignment.', 17], ['Expression on left side of assignment is not assignable.', 31], ['Expression on left side of assignment is not assignable.', 33], ['Nullsafe operator cannot be on right side of assignment by reference.', 39], ['Nullsafe operator cannot be on right side of assignment by reference.', 40]]);
    }
}
