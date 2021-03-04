<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @extends RuleTestCase<MixinRule>
 */
class MixinRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $reflectionProvider = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes\MixinRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), $reflectionProvider, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($reflectionProvider), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck($reflectionProvider, \true, \true, \true), \true);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/mixin.php'], [['PHPDoc tag @mixin contains non-object type int.', 16], ['PHPDoc tag @mixin contains unresolvable type.', 24], ['PHPDoc tag @mixin contains generic type Exception<MixinRule\\Foo> but class Exception is not generic.', 34], ['Generic type Traversable<int, int, int> in PHPDoc tag @mixin specifies 3 template types, but class Traversable supports only 2: TKey, TValue', 34], ['Type string in generic type ReflectionClass<string> in PHPDoc tag @mixin is not subtype of template type T of object of class ReflectionClass.', 34], ['PHPDoc tag @mixin contains generic class ReflectionClass but does not specify its types: T', 50, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.'], ['PHPDoc tag @mixin contains unknown class MixinRule\\UnknownestClass.', 50, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['PHPDoc tag @mixin contains invalid type MixinRule\\FooTrait.', 50], ['PHPDoc tag @mixin contains unknown class MixinRule\\U.', 59, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['Generic type MixinRule\\Consecteur<MixinRule\\Foo> in PHPDoc tag @mixin does not specify all template types of class MixinRule\\Consecteur: T, U', 76], ['Class MixinRule\\Foo referenced with incorrect case: MixinRule\\foo.', 84]]);
    }
}
