<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<DefaultValueTypesAssignedToPropertiesRule>
 */
class DefaultValueTypesAssignedToPropertiesRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\DefaultValueTypesAssignedToPropertiesRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testDefaultValueTypesAssignedToProperties() : void
    {
        $this->analyse([__DIR__ . '/data/properties-assigned-default-value-types.php'], [['Property PropertiesAssignedDefaultValuesTypes\\Foo::$stringPropertyWithWrongDefaultValue (string) does not accept default value of type int.', 15], ['Static property PropertiesAssignedDefaultValuesTypes\\Foo::$staticStringPropertyWithWrongDefaultValue (string) does not accept default value of type int.', 18], ['Static property PropertiesAssignedDefaultValuesTypes\\Foo::$windowsNtVersions (array<string, string>) does not accept default value of type array<int|string, string>.', 24]]);
    }
    public function testDefaultValueForNativePropertyType() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/default-value-for-native-property-type.php'], [['Property DefaultValueForNativePropertyType\\Foo::$foo (DateTime) does not accept default value of type null.', 8]]);
    }
    public function testDefaultValueForPromotedProperty() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires static reflection.');
        }
        $this->analyse([__DIR__ . '/data/default-value-for-promoted-property.php'], [['Property DefaultValueForPromotedProperty\\Foo::$foo (int) does not accept default value of type string.', 9], ['Property DefaultValueForPromotedProperty\\Foo::$foo (int) does not accept default value of type string.', 10]]);
    }
}
