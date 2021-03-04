<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<WritingToReadOnlyPropertiesRule>
 */
class WritingToReadOnlyPropertiesRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var bool */
    private $checkThisOnly;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\WritingToReadOnlyPropertiesRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyDescriptor(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder(), $this->checkThisOnly);
    }
    public function testCheckThisOnlyProperties() : void
    {
        $this->checkThisOnly = \true;
        $this->analyse([__DIR__ . '/data/writing-to-read-only-properties.php'], [['Property WritingToReadOnlyProperties\\Foo::$readOnlyProperty is not writable.', 15], ['Property WritingToReadOnlyProperties\\Foo::$readOnlyProperty is not writable.', 16]]);
    }
    public function testCheckAllProperties() : void
    {
        $this->checkThisOnly = \false;
        $this->analyse([__DIR__ . '/data/writing-to-read-only-properties.php'], [['Property WritingToReadOnlyProperties\\Foo::$readOnlyProperty is not writable.', 15], ['Property WritingToReadOnlyProperties\\Foo::$readOnlyProperty is not writable.', 16], ['Property WritingToReadOnlyProperties\\Foo::$readOnlyProperty is not writable.', 25], ['Property WritingToReadOnlyProperties\\Foo::$readOnlyProperty is not writable.', 26], ['Property WritingToReadOnlyProperties\\Foo::$readOnlyProperty is not writable.', 35]]);
    }
}
