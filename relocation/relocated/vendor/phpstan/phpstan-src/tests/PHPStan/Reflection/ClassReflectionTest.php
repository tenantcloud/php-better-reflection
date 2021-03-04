<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\Attributes\IsAttribute;
use TenantCloud\BetterReflection\Relocated\Attributes\IsAttribute2;
use TenantCloud\BetterReflection\Relocated\Attributes\IsAttribute3;
use TenantCloud\BetterReflection\Relocated\Attributes\IsNotAttribute;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
class ClassReflectionTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataHasTraitUse() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\HasTraitUse\Foo::class, \true], [\TenantCloud\BetterReflection\Relocated\HasTraitUse\Bar::class, \true], [\TenantCloud\BetterReflection\Relocated\HasTraitUse\Baz::class, \false]];
    }
    /**
     * @dataProvider dataHasTraitUse
     * @param class-string $className
     * @param bool $has
     */
    public function testHasTraitUse(string $className, bool $has) : void
    {
        $broker = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::class);
        $fileTypeMapper = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class);
        $classReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection($broker, $fileTypeMapper, new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion(\PHP_VERSION_ID), [], [], $className, new \ReflectionClass($className), null, null, null);
        $this->assertSame($has, $classReflection->hasTraitUse(\TenantCloud\BetterReflection\Relocated\HasTraitUse\FooTrait::class));
    }
    public function dataClassHierarchyDistances() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\HierarchyDistances\Lorem::class, [\TenantCloud\BetterReflection\Relocated\HierarchyDistances\Lorem::class => 0, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitTwo::class => 1, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitThree::class => 2, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\FirstLoremInterface::class => 3, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\SecondLoremInterface::class => 4]], [\TenantCloud\BetterReflection\Relocated\HierarchyDistances\Ipsum::class, \PHP_VERSION_ID < 70400 ? [\TenantCloud\BetterReflection\Relocated\HierarchyDistances\Ipsum::class => 0, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitOne::class => 1, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\Lorem::class => 2, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitTwo::class => 3, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitThree::class => 4, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\SecondLoremInterface::class => 5, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\FirstLoremInterface::class => 6, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\FirstIpsumInterface::class => 7, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\ExtendedIpsumInterface::class => 8, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\SecondIpsumInterface::class => 9, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\ThirdIpsumInterface::class => 10] : [\TenantCloud\BetterReflection\Relocated\HierarchyDistances\Ipsum::class => 0, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitOne::class => 1, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\Lorem::class => 2, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitTwo::class => 3, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\TraitThree::class => 4, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\FirstLoremInterface::class => 5, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\SecondLoremInterface::class => 6, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\FirstIpsumInterface::class => 7, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\SecondIpsumInterface::class => 8, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\ThirdIpsumInterface::class => 9, \TenantCloud\BetterReflection\Relocated\HierarchyDistances\ExtendedIpsumInterface::class => 10]]];
    }
    /**
     * @dataProvider dataClassHierarchyDistances
     * @param class-string $class
     * @param int[] $expectedDistances
     */
    public function testClassHierarchyDistances(string $class, array $expectedDistances) : void
    {
        $broker = $this->createReflectionProvider();
        $fileTypeMapper = $this->createMock(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class);
        $classReflection = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection($broker, $fileTypeMapper, new \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion(\PHP_VERSION_ID), [], [], $class, new \ReflectionClass($class), null, null, null);
        $this->assertSame($expectedDistances, $classReflection->getClassHierarchyDistances());
    }
    public function testVariadicTraitMethod() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $fooReflection = $broker->getClass(\TenantCloud\BetterReflection\Relocated\HasTraitUse\Foo::class);
        $variadicMethod = $fooReflection->getNativeMethod('variadicMethod');
        $methodVariant = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($variadicMethod->getVariants());
        $this->assertTrue($methodVariant->isVariadic());
    }
    public function testGenericInheritance() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $reflection = $broker->getClass(\TenantCloud\BetterReflection\Relocated\GenericInheritance\C::class);
        $this->assertSame('TenantCloud\\BetterReflection\\Relocated\\GenericInheritance\\C', $reflection->getDisplayName());
        $parent = $reflection->getParentClass();
        $this->assertNotFalse($parent);
        $this->assertSame('GenericInheritance\\C0<DateTime>', $parent->getDisplayName());
        $this->assertSame(['GenericInheritance\\I0<DateTime>', 'GenericInheritance\\I1<int>', 'GenericInheritance\\I<DateTime>'], \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $r) : string {
            return $r->getDisplayName();
        }, \array_values($reflection->getInterfaces())));
    }
    public function testGenericInheritanceOverride() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $reflection = $broker->getClass(\TenantCloud\BetterReflection\Relocated\GenericInheritance\Override::class);
        $this->assertSame(['GenericInheritance\\I0<DateTimeInterface>', 'GenericInheritance\\I1<int>', 'GenericInheritance\\I<DateTimeInterface>'], \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $r) : string {
            return $r->getDisplayName();
        }, \array_values($reflection->getInterfaces())));
    }
    public function testIsGenericWithStubPhpDoc() : void
    {
        /** @var Broker $broker */
        $broker = self::getContainer()->getService('broker');
        $reflection = $broker->getClass(\ReflectionClass::class);
        $this->assertTrue($reflection->isGeneric());
    }
    public function dataIsAttributeClass() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\Attributes\IsNotAttribute::class, \false], [\TenantCloud\BetterReflection\Relocated\Attributes\IsAttribute::class, \true], [\TenantCloud\BetterReflection\Relocated\Attributes\IsAttribute2::class, \true, \Attribute::IS_REPEATABLE], [\TenantCloud\BetterReflection\Relocated\Attributes\IsAttribute3::class, \true, \Attribute::IS_REPEATABLE | \Attribute::TARGET_PROPERTY]];
    }
    /**
     * @dataProvider dataIsAttributeClass
     * @param string $className
     * @param bool $expected
     */
    public function testIsAttributeClass(string $className, bool $expected, int $expectedFlags = \Attribute::TARGET_ALL) : void
    {
        if (!self::$useStaticReflectionProvider && \PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Test requires PHP 8.0.');
        }
        $reflectionProvider = $this->createBroker();
        $reflection = $reflectionProvider->getClass($className);
        $this->assertSame($expected, $reflection->isAttributeClass());
        if (!$expected) {
            return;
        }
        $this->assertSame($expectedFlags, $reflection->getAttributeClassFlags());
    }
}
