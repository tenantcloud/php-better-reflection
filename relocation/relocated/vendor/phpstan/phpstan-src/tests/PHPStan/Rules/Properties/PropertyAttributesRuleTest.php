<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\AttributesCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends RuleTestCase<PropertyAttributesRule>
 */
class PropertyAttributesRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $reflectionProvider = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyAttributesRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\AttributesCheck($reflectionProvider, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($reflectionProvider, \true, \false, \true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NullsafeCheck(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion(80000), \true, \true, \true, \true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($reflectionProvider, \false)));
    }
    public function testRule() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/property-attributes.php'], [['Attribute class PropertyAttributes\\Foo does not have the property target.', 26]]);
    }
}