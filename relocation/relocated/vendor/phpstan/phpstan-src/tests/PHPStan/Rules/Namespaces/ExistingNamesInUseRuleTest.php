<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Namespaces;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ExistingNamesInUseRule>
 */
class ExistingNamesInUseRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Namespaces\ExistingNamesInUseRule($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker, \true), \true);
    }
    public function testRule() : void
    {
        require_once __DIR__ . '/data/uses-defined.php';
        $this->analyse([__DIR__ . '/data/uses.php'], [['Used function Uses\\bar not found.', 7, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Used constant Uses\\OTHER_CONSTANT not found.', 8, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Function Uses\\foo used with incorrect case: Uses\\Foo.', 9], ['Interface Uses\\Lorem referenced with incorrect case: Uses\\LOREM.', 10], ['Class DateTime referenced with incorrect case: DATETIME.', 11]]);
    }
}
