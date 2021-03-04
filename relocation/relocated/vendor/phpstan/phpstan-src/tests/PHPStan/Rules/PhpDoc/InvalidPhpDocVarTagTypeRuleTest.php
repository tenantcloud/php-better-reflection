<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidPhpDocVarTagTypeRule>
 */
class InvalidPhpDocVarTagTypeRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\PhpDoc\InvalidPhpDocVarTagTypeRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), $broker, new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\ClassCaseSensitivityCheck($broker), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck($broker, \true, \true, \true), \true, \true);
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-var-tag-type.php'], [['PHPDoc tag @var for variable $test contains unresolvable type.', 13], ['PHPDoc tag @var contains unresolvable type.', 16], ['PHPDoc tag @var for variable $test contains unknown class InvalidVarTagType\\aray.', 20, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['PHPDoc tag @var for variable $value contains unresolvable type.', 22], ['PHPDoc tag @var for variable $staticVar contains unresolvable type.', 27], ['Class InvalidVarTagType\\Foo referenced with incorrect case: InvalidVarTagType\\foo.', 31], ['PHPDoc tag @var for variable $test has invalid type InvalidVarTagType\\FooTrait.', 34], ['PHPDoc tag @var for variable $test contains generic type InvalidPhpDoc\\Foo<stdClass> but class InvalidPhpDoc\\Foo is not generic.', 40], ['Generic type InvalidPhpDocDefinitions\\FooGeneric<int> in PHPDoc tag @var for variable $test does not specify all template types of class InvalidPhpDocDefinitions\\FooGeneric: T, U', 46], ['Generic type InvalidPhpDocDefinitions\\FooGeneric<int, InvalidArgumentException, string> in PHPDoc tag @var for variable $test specifies 3 template types, but class InvalidPhpDocDefinitions\\FooGeneric supports only 2: T, U', 49], ['Type Throwable in generic type InvalidPhpDocDefinitions\\FooGeneric<int, Throwable> in PHPDoc tag @var for variable $test is not subtype of template type U of Exception of class InvalidPhpDocDefinitions\\FooGeneric.', 52], ['Type stdClass in generic type InvalidPhpDocDefinitions\\FooGeneric<int, stdClass> in PHPDoc tag @var for variable $test is not subtype of template type U of Exception of class InvalidPhpDocDefinitions\\FooGeneric.', 55], ['PHPDoc tag @var for variable $test has no value type specified in iterable type array.', 58, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP], ['PHPDoc tag @var for variable $test contains generic class InvalidPhpDocDefinitions\\FooGeneric but does not specify its types: T, U', 61, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.'], ['PHPDoc tag @var for variable $foo contains unknown class InvalidVarTagType\\Blabla.', 67, 'Learn more at https://phpstan.org/user-guide/discovering-symbols']]);
    }
    public function testBug4486() : void
    {
        $this->analyse([__DIR__ . '/data/bug-4486.php'], [['PHPDoc tag @var for variable $one contains unknown class Bug4486\\ClassName1.', 10, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['PHPDoc tag @var for variable $two contains unknown class Bug4486\\ClassName2.', 10, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['PHPDoc tag @var for variable $three contains unknown class Some\\Namespaced\\ClassName1.', 15, 'Learn more at https://phpstan.org/user-guide/discovering-symbols']]);
    }
    public function testBug4486Namespace() : void
    {
        $this->analyse([__DIR__ . '/data/bug-4486-ns.php'], [['PHPDoc tag @var for variable $one contains unknown class ClassName1.', 6, 'Learn more at https://phpstan.org/user-guide/discovering-symbols'], ['PHPDoc tag @var for variable $two contains unknown class Bug4486Namespace\\ClassName1.', 10, 'Learn more at https://phpstan.org/user-guide/discovering-symbols']]);
    }
}
