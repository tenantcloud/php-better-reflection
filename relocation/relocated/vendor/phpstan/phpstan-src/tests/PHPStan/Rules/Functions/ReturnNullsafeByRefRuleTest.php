<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<ReturnNullsafeByRefRule>
 */
class ReturnNullsafeByRefRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions\ReturnNullsafeByRefRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck());
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/return-null-safe-by-ref.php'], [['Nullsafe cannot be returned by reference.', 15], ['Nullsafe cannot be returned by reference.', 25], ['Nullsafe cannot be returned by reference.', 36]]);
    }
}
