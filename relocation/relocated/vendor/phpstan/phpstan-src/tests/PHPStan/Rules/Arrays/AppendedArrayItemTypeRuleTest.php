<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<AppendedArrayItemTypeRule>
 */
class AppendedArrayItemTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Arrays\AppendedArrayItemTypeRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testAppendedArrayItemType() : void
    {
        $this->analyse([__DIR__ . '/data/appended-array-item.php'], [['Array (array<int>) does not accept string.', 18], ['Array (array<callable(): mixed>) does not accept array(1, 2, 3).', 20], ['Array (array<callable(): mixed>) does not accept array(\'AppendedArrayItem\\\\Foo\', \'classMethod\').', 23], ['Array (array<callable(): mixed>) does not accept array(\'Foo\', \'Hello world\').', 25], ['Array (array<int>) does not accept string.', 27], ['Array (array<int>) does not accept string.', 32], ['Array (array<callable(): string>) does not accept Closure(): 1.', 45], ['Array (array<AppendedArrayItem\\Lorem>) does not accept AppendedArrayItem\\Baz.', 79]]);
    }
}
