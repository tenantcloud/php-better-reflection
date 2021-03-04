<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
/**
 * @extends \PHPStan\Testing\RuleTestCase<AccessStaticPropertiesInAssignRule>
 */
class AccessStaticPropertiesInAssignRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\AccessStaticPropertiesInAssignRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\AccessStaticPropertiesRule($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper($broker, \true, \false, \true, \false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker)));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/access-static-properties-assign.php'], [['Access to an undefined static property TestAccessStaticPropertiesAssign\\AccessStaticPropertyWithDimFetch::$foo.', 15]]);
    }
    public function testRuleExpressionNames() : void
    {
        $this->analyse([__DIR__ . '/data/properties-from-array-into-static-object.php'], [['Access to an undefined static property PropertiesFromArrayIntoStaticObject\\Foo::$noop.', 29]]);
    }
}
