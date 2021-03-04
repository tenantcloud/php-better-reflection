<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use const PHP_VERSION_ID;
/**
 * @extends RuleTestCase<UninitializedPropertyRule>
 */
class UninitializedPropertyRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\UninitializedPropertyRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\DirectReadWritePropertiesExtensionProvider([new class implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ReadWritePropertiesExtension
        {
            public function isAlwaysRead(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool
            {
                return \false;
            }
            public function isAlwaysWritten(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool
            {
                return \false;
            }
            public function isInitialized(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool
            {
                return $property->getDeclaringClass()->getName() === 'UninitializedProperty\\TestExtension' && $propertyName === 'inited';
            }
        }]), ['UninitializedProperty\\TestCase::setUp']);
    }
    public function testRule() : void
    {
        if (\PHP_VERSION_ID < 70400 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 7.4.');
        }
        $this->analyse([__DIR__ . '/data/uninitialized-property.php'], [['Class UninitializedProperty\\Foo has an uninitialized property $bar. Give it default value or assign it in the constructor.', 10], ['Class UninitializedProperty\\Foo has an uninitialized property $baz. Give it default value or assign it in the constructor.', 12], ['Access to an uninitialized property UninitializedProperty\\Bar::$foo.', 33], ['Class UninitializedProperty\\Lorem has an uninitialized property $baz. Give it default value or assign it in the constructor.', 59], ['Class UninitializedProperty\\TestExtension has an uninitialized property $uninited. Give it default value or assign it in the constructor.', 122]]);
    }
    public function testPromotedProperties() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        $this->analyse([__DIR__ . '/data/uninitialized-property-promoted.php'], []);
    }
}
