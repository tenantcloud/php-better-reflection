<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidKeyInArrayDimFetchRule>
 */
class InvalidKeyInArrayDimFetchRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\InvalidKeyInArrayDimFetchRule(\true);
    }
    public function testInvalidKey() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-key-array-dim-fetch.php'], [['Invalid array key type DateTimeImmutable.', 7], ['Invalid array key type array.', 8], ['Possibly invalid array key type stdClass|string.', 24], ['Invalid array key type DateTimeImmutable.', 31]]);
    }
}
