<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators;

/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidIncDecOperationRule>
 */
class InvalidIncDecOperationRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators\InvalidIncDecOperationRule(\false);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-inc-dec.php'], [['Cannot use ++ on a non-variable.', 11], ['Cannot use -- on a non-variable.', 12], ['Cannot use ++ on stdClass.', 17]]);
    }
}
