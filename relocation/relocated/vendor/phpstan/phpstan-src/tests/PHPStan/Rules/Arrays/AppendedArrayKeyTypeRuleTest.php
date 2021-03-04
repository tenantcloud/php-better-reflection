<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder;
/**
 * @extends \PHPStan\Testing\RuleTestCase<AppendedArrayKeyTypeRule>
 */
class AppendedArrayKeyTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\AppendedArrayKeyTypeRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder(), \true);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/appended-array-key.php'], [['Array (array<int, mixed>) does not accept key int|string.', 28], ['Array (array<int, mixed>) does not accept key string.', 30], ['Array (array<string, mixed>) does not accept key int.', 31], ['Array (array<string, mixed>) does not accept key int|string.', 33], ['Array (array<string, mixed>) does not accept key 0.', 38], ['Array (array<string, mixed>) does not accept key 1.', 46]]);
    }
}
