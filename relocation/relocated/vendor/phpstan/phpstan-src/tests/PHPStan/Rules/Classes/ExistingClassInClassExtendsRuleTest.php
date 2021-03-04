<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ExistingClassInClassExtendsRule>
 */
class ExistingClassInClassExtendsRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), $broker);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/extends-implements.php'], [['Class ExtendsImplements\\Foo referenced with incorrect case: ExtendsImplements\\FOO.', 15]]);
    }
    public function testRuleExtendsError() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('This test needs static reflection');
        }
        $this->analyse([__DIR__ . '/data/extends-error.php'], [['Class ExtendsError\\Foo extends unknown class ExtendsError\\Bar.', 5, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Class ExtendsError\\Lorem extends interface ExtendsError\\BazInterface.', 15], ['Class ExtendsError\\Ipsum extends trait ExtendsError\\DolorTrait.', 25], ['Anonymous class extends trait ExtendsError\\DolorTrait.', 30], ['Class ExtendsError\\Sit extends final class ExtendsError\\FinalFoo.', 39]]);
    }
}
