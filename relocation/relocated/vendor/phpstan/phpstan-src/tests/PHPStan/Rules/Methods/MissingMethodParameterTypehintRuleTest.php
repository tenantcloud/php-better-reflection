<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck;
/**
 * @extends \PHPStan\Testing\RuleTestCase<MissingMethodParameterTypehintRule>
 */
class MissingMethodParameterTypehintRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        $broker = $this->createReflectionProvider();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck($broker, \true, \true, \true));
    }
    public function testRule() : void
    {
        $errors = [['Method MissingMethodParameterTypehint\\FooInterface::getFoo() has parameter $p1 with no typehint specified.', 8], ['Method MissingMethodParameterTypehint\\FooParent::getBar() has parameter $p2 with no typehint specified.', 15], ['Method MissingMethodParameterTypehint\\Foo::getFoo() has parameter $p1 with no typehint specified.', 25], ['Method MissingMethodParameterTypehint\\Foo::getBar() has parameter $p2 with no typehint specified.', 33], ['Method MissingMethodParameterTypehint\\Foo::getBaz() has parameter $p3 with no typehint specified.', 42], ['Method MissingMethodParameterTypehint\\Foo::unionTypeWithUnknownArrayValueTypehint() has parameter $a with no value type specified in iterable type array.', 58, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP], ['Method MissingMethodParameterTypehint\\Bar::acceptsGenericInterface() has parameter $i with generic interface MissingMethodParameterTypehint\\GenericInterface but does not specify its types: T, U', 91, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.'], ['Method MissingMethodParameterTypehint\\Bar::acceptsGenericClass() has parameter $c with generic class MissingMethodParameterTypehint\\GenericClass but does not specify its types: A, B', 101, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.'], ['Method MissingMethodParameterTypehint\\CollectionIterableAndGeneric::acceptsCollection() has parameter $collection with generic interface DoctrineIntersectionTypeIsSupertypeOf\\Collection but does not specify its types: TKey, T', 111, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.'], ['Method MissingMethodParameterTypehint\\CollectionIterableAndGeneric::acceptsCollection2() has parameter $collection with generic interface DoctrineIntersectionTypeIsSupertypeOf\\Collection but does not specify its types: TKey, T', 119, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.'], ['Method MissingMethodParameterTypehint\\CallableSignature::doFoo() has parameter $cb with no signature specified for callable.', 180]];
        $this->analyse([__DIR__ . '/data/missing-method-parameter-typehint.php'], $errors);
    }
    public function testPromotedProperties() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->analyse([__DIR__ . '/data/missing-typehint-promoted-properties.php'], [['Method MissingTypehintPromotedProperties\\Foo::__construct() has parameter $foo with no value type specified in iterable type array.', 8, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP], ['Method MissingTypehintPromotedProperties\\Bar::__construct() has parameter $foo with no value type specified in iterable type array.', 21, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MissingTypehintCheck::TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP]]);
    }
}
