<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UnusedFunctionParametersCheck;
/**
 * @extends \PHPStan\Testing\RuleTestCase<UnusedConstructorParametersRule>
 */
class UnusedConstructorParametersRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\UnusedConstructorParametersRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\UnusedFunctionParametersCheck($this->createReflectionProvider()));
    }
    public function testUnusedConstructorParameters() : void
    {
        $this->analyse([__DIR__ . '/data/unused-constructor-parameters.php'], [['Constructor of class UnusedConstructorParameters\\Foo has an unused parameter $unusedParameter.', 11], ['Constructor of class UnusedConstructorParameters\\Foo has an unused parameter $anotherUnusedParameter.', 11]]);
    }
    public function testPromotedProperties() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0');
        }
        $this->analyse([__DIR__ . '/data/unused-constructor-parameters-promoted-properties.php'], []);
    }
    public function testBug1917() : void
    {
        $this->analyse([__DIR__ . '/data/bug-1917.php'], []);
    }
}
