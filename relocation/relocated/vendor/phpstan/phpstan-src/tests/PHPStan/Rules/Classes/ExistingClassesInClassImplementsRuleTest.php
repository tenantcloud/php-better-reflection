<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ExistingClassesInClassImplementsRule>
 */
class ExistingClassesInClassImplementsRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), $broker);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/extends-implements.php'], [['Interface ExtendsImplements\\FooInterface referenced with incorrect case: ExtendsImplements\\FOOInterface.', 15]]);
    }
    public function testRuleImplementsError() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('This test needs static reflection');
        }
        $this->analyse([__DIR__ . '/data/implements-error.php'], [['Class ImplementsError\\Foo implements unknown interface ImplementsError\\Bar.', 5, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Class ImplementsError\\Lorem implements class ImplementsError\\Foo.', 10], ['Class ImplementsError\\Ipsum implements trait ImplementsError\\DolorTrait.', 20], ['Anonymous class implements trait ImplementsError\\DolorTrait.', 25]]);
    }
}
