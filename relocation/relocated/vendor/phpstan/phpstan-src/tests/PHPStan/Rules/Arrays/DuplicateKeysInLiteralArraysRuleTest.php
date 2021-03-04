<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

/**
 * @extends \PHPStan\Testing\RuleTestCase<DuplicateKeysInLiteralArraysRule>
 */
class DuplicateKeysInLiteralArraysRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\DuplicateKeysInLiteralArraysRule(new \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard());
    }
    public function testDuplicateKeys() : void
    {
        \define('PHPSTAN_DUPLICATE_KEY', 0);
        $this->analyse([__DIR__ . '/data/duplicate-keys.php'], [['Array has 2 duplicate keys with value \'\' (null, NULL).', 15], ['Array has 4 duplicate keys with value 1 (1, 1, 1.0, true).', 17], ['Array has 3 duplicate keys with value 0 (false, 0, PHPSTAN_DUPLICATE_KEY).', 23], ['Array has 2 duplicate keys with value \'=\' (self::EQ, self::IS).', 32], ['Array has 2 duplicate keys with value 2 ($idx, $idx).', 55]]);
    }
}
