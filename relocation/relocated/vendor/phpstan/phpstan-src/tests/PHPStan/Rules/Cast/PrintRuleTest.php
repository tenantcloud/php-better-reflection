<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<PrintRule>
 */
class PrintRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast\PrintRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testPrintRule() : void
    {
        $this->analyse([__DIR__ . '/data/print.php'], [['Parameter array() of print cannot be converted to string.', 5], ['Parameter stdClass of print cannot be converted to string.', 7], ['Parameter Closure(): void of print cannot be converted to string.', 9], ['Parameter array() of print cannot be converted to string.', 13], ['Parameter stdClass of print cannot be converted to string.', 15], ['Parameter Closure(): void of print cannot be converted to string.', 17], ['Parameter \'string\'|array(\'string\') of print cannot be converted to string.', 21]]);
    }
}
