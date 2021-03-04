<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generators;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<YieldTypeRule>
 */
class YieldTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generators\YieldTypeRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/yield.php'], [['Generator expects value type int, string given.', 14], ['Generator expects key type string, int given.', 15], ['Generator expects value type int, null given.', 15], ['Generator expects key type string, int given.', 16], ['Generator expects key type string, int given.', 17], ['Generator expects value type int, string given.', 17], ['Generator expects value type array(0 => DateTime, 1 => DateTime, 2 => stdClass, 4 => DateTimeImmutable), array(DateTime, DateTime, stdClass, DateTimeImmutable) given.', 25], ['Result of yield (void) is used.', 137], ['Result of yield (void) is used.', 138]]);
    }
}
