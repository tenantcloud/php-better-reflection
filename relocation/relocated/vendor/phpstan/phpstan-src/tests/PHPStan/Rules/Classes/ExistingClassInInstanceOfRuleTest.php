<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ExistingClassInInstanceOfRule>
 */
class ExistingClassInInstanceOfRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassInInstanceOfRule($broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), \true);
    }
    public function testClassDoesNotExist() : void
    {
        $this->analyse([__DIR__ . '/data/instanceof.php', __DIR__ . '/data/instanceof-defined.php'], [['Class InstanceOfNamespace\\Bar not found.', 7, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Using self outside of class scope.', 9], ['Class InstanceOfNamespace\\Foo referenced with incorrect case: InstanceOfNamespace\\FOO.', 13], ['Using parent outside of class scope.', 15], ['Using self outside of class scope.', 17]]);
    }
    public function testClassExists() : void
    {
        $this->analyse([__DIR__ . '/data/instanceof-class-exists.php'], []);
    }
}
