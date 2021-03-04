<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<EchoRule>
 */
class EchoRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Cast\EchoRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testEchoRule() : void
    {
        $this->analyse([__DIR__ . '/data/echo.php'], [['Parameter #1 (array()) of echo cannot be converted to string.', 7], ['Parameter #1 (stdClass) of echo cannot be converted to string.', 9], ['Parameter #1 (array()) of echo cannot be converted to string.', 11], ['Parameter #2 (stdClass) of echo cannot be converted to string.', 11], ['Parameter #1 (Closure(): void) of echo cannot be converted to string.', 13], ['Parameter #1 (\'string\'|array(\'string\')) of echo cannot be converted to string.', 17]]);
    }
}
