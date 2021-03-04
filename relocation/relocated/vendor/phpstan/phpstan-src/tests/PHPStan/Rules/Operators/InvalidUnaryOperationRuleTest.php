<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators;

/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidUnaryOperationRule>
 */
class InvalidUnaryOperationRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Operators\InvalidUnaryOperationRule();
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-unary.php'], [['Unary operation "+" on string results in an error.', 11], ['Unary operation "-" on string results in an error.', 12], ['Unary operation "+" on \'bla\' results in an error.', 19], ['Unary operation "-" on \'bla\' results in an error.', 20], ['Unary operation "~" on array() results in an error.', 24]]);
    }
}
