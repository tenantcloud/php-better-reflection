<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<VariableCloningRule>
 */
class VariableCloningRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Variables\VariableCloningRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($this->createReflectionProvider(), \true, \false, \true, \false));
    }
    public function testClone() : void
    {
        $this->analyse([__DIR__ . '/data/variable-cloning.php'], [['Cannot clone int|string.', 11], ['Cannot clone non-object variable $stringData of type string.', 14], ['Cannot clone string.', 15], ['Cannot clone non-object variable $bar of type string|VariableCloning\\Foo.', 19], ['Cloning object of an unknown class VariableCloning\\Bar.', 23, 'Learn more at https://phpstan.org/user-guide/discovering-symbols']]);
    }
}
