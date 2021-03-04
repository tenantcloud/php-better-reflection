<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class GenericClassStringTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [0 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 1 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 2 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 3 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Throwable::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 4 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\InvalidArgumentException::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 5 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 6 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 7 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Throwable::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 8 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 9 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 10 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', null, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 11 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 12 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\stdClass::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 13 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\InvalidArgumentException::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 14 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Throwable::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 15 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 16 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType(\InvalidArgumentException::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 17 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType(\Throwable::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : array
    {
        return [0 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Throwable::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 1 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 2 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\InvalidArgumentException::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 3 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 4 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 5 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 6 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', null, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('NonexistentClass'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], 7 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', null, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\DateTime::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\Exception::class)]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 8 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], 9 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Boo'), 'U', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 10 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], 11 => [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataAccepts
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType $acceptingType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptedType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $acceptingType->accepts($acceptedType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $acceptingType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class)), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType(\Exception::class)), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType(\Exception::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType(\stdClass::class)), \false]];
    }
    /**
     * @dataProvider dataEquals
     */
    public function testEquals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, bool $expected) : void
    {
        $verbosityLevel = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise();
        $typeDescription = $type->describe($verbosityLevel);
        $otherTypeDescription = $otherType->describe($verbosityLevel);
        $actual = $type->equals($otherType);
        $this->assertSame($expected, $actual, \sprintf('%s -> equals(%s)', $typeDescription, $otherTypeDescription));
        $actual = $otherType->equals($type);
        $this->assertSame($expected, $actual, \sprintf('%s -> equals(%s)', $otherTypeDescription, $typeDescription));
    }
}