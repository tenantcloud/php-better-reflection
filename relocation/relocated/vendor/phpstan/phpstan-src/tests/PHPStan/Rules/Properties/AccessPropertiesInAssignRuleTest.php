<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<AccessPropertiesInAssignRule>
 */
class AccessPropertiesInAssignRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\AccessPropertiesInAssignRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\AccessPropertiesRule($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($broker, \true, \false, \true, \false), \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/access-properties-assign.php'], [['Access to an undefined property TestAccessPropertiesAssign\\AccessPropertyWithDimFetch::$foo.', 15]]);
    }
    public function testRuleExpressionNames() : void
    {
        $this->analyse([__DIR__ . '/data/properties-from-variable-into-object.php'], [['Access to an undefined property PropertiesFromVariableIntoObject\\Foo::$noop.', 26]]);
    }
    public function testRuleExpressionNames2() : void
    {
        $this->analyse([__DIR__ . '/data/properties-from-array-into-object.php'], [['Access to an undefined property PropertiesFromArrayIntoObject\\Foo::$noop.', 42], ['Access to an undefined property PropertiesFromArrayIntoObject\\Foo::$noop.', 54], ['Access to an undefined property PropertiesFromArrayIntoObject\\Foo::$noop.', 69], ['Access to an undefined property PropertiesFromArrayIntoObject\\Foo::$noop.', 110]]);
    }
}
