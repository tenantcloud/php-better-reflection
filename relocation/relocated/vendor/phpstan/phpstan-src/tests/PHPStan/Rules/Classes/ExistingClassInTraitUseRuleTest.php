<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
/**
 * @extends \PHPStan\Testing\RuleTestCase<ExistingClassInTraitUseRule>
 */
class ExistingClassInTraitUseRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\ExistingClassInTraitUseRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), $broker);
    }
    public function testClassWithWrongCase() : void
    {
        $this->analyse([__DIR__ . '/data/trait-use.php'], [['Trait TraitUseCase\\FooTrait referenced with incorrect case: TraitUseCase\\FOOTrait.', 13]]);
    }
    public function testTraitUseError() : void
    {
        if (!self::$useStaticReflectionProvider) {
            $this->markTestSkipped('This test needs static reflection');
        }
        $this->analyse([__DIR__ . '/data/trait-use-error.php'], [
            ['Class TraitUseError\\Foo uses unknown trait TraitUseError\\FooTrait.', 8, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'],
            /*[
            			'Trait TraitUseError\BarTrait uses class TraitUseError\Foo.',
            			15,
            		],
            		[
            			'Trait TraitUseError\BarTrait uses unknown trait TraitUseError\FooTrait. ',
            			15,
            		],*/
            ['Interface TraitUseError\\Baz uses trait TraitUseError\\BarTrait.', 22],
            ['Anonymous class uses unknown trait TraitUseError\\FooTrait.', 27, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'],
            ['Anonymous class uses interface TraitUseError\\Baz.', 28],
        ]);
    }
}
