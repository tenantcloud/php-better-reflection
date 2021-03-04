<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\DirectReadWritePropertiesExtensionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ReadWritePropertiesExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use const PHP_VERSION_ID;
/**
 * @extends RuleTestCase<UnusedPrivatePropertyRule>
 */
class UnusedPrivatePropertyRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    /** @var string[] */
    private $alwaysWrittenTags;
    /** @var string[] */
    private $alwaysReadTags;
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\DeadCode\UnusedPrivatePropertyRule(new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\DirectReadWritePropertiesExtensionProvider([new class implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\ReadWritePropertiesExtension
        {
            public function isAlwaysRead(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool
            {
                return $property->getDeclaringClass()->getName() === 'UnusedPrivateProperty\\TestExtension' && \in_array($propertyName, ['read', 'used'], \true);
            }
            public function isAlwaysWritten(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool
            {
                return $property->getDeclaringClass()->getName() === 'UnusedPrivateProperty\\TestExtension' && \in_array($propertyName, ['written', 'used'], \true);
            }
            public function isInitialized(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property, string $propertyName) : bool
            {
                return \false;
            }
        }]), $this->alwaysWrittenTags, $this->alwaysReadTags, \true);
    }
    public function testRule() : void
    {
        if (\PHP_VERSION_ID < 70400 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 7.4 or static reflection.');
        }
        $this->alwaysWrittenTags = [];
        $this->alwaysReadTags = [];
        $this->analyse([__DIR__ . '/data/unused-private-property.php'], [['Property UnusedPrivateProperty\\Foo::$bar is never read, only written.', 10], ['Property UnusedPrivateProperty\\Foo::$baz is unused.', 12], ['Property UnusedPrivateProperty\\Foo::$lorem is never written, only read.', 14], ['Property UnusedPrivateProperty\\Bar::$baz is never written, only read.', 57], ['Static property UnusedPrivateProperty\\Baz::$bar is never read, only written.', 86], ['Static property UnusedPrivateProperty\\Baz::$baz is unused.', 88], ['Static property UnusedPrivateProperty\\Baz::$lorem is never written, only read.', 90], ['Property UnusedPrivateProperty\\Lorem::$baz is never read, only written.', 117], ['Property class@anonymous/tests/PHPStan/Rules/DeadCode/data/unused-private-property.php:152::$bar is unused.', 153], ['Property UnusedPrivateProperty\\DolorWithAnonymous::$foo is unused.', 148]]);
        $this->analyse([__DIR__ . '/data/TestExtension.php'], [['Property UnusedPrivateProperty\\TestExtension::$unused is unused.', 8], ['Property UnusedPrivateProperty\\TestExtension::$read is never written, only read.', 10], ['Property UnusedPrivateProperty\\TestExtension::$written is never read, only written.', 12]]);
    }
    public function testAlwaysUsedTags() : void
    {
        $this->alwaysWrittenTags = ['TenantCloud\\BetterReflection\\Relocated\\@ORM\\Column'];
        $this->alwaysReadTags = ['@get'];
        $this->analyse([__DIR__ . '/data/private-property-with-tags.php'], [['Property PrivatePropertyWithTags\\Foo::$title is never read, only written.', 13], ['Property PrivatePropertyWithTags\\Foo::$text is never written, only read.', 18]]);
    }
    public function testTrait() : void
    {
        $this->alwaysWrittenTags = [];
        $this->alwaysReadTags = [];
        $this->analyse([__DIR__ . '/data/private-property-trait.php'], []);
    }
    public function testBug3636() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 70400) {
            $this->markTestSkipped('Test requires PHP 7.4.');
        }
        $this->alwaysWrittenTags = [];
        $this->alwaysReadTags = [];
        $this->analyse([__DIR__ . '/data/bug-3636.php'], [['Property Bug3636\\Bar::$date is never written, only read.', 22]]);
    }
    public function testPromotedProperties() : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->alwaysWrittenTags = [];
        $this->alwaysReadTags = ['@get'];
        $this->analyse([__DIR__ . '/data/unused-private-promoted-property.php'], [['Property UnusedPrivatePromotedProperty\\Foo::$lorem is never read, only written.', 12]]);
    }
    public function testNullsafe() : void
    {
        if (\PHP_VERSION_ID < 80000 && !self::$useStaticReflectionProvider) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $this->alwaysWrittenTags = [];
        $this->alwaysReadTags = [];
        $this->analyse([__DIR__ . '/data/nullsafe-unused-private-property.php'], []);
    }
}
