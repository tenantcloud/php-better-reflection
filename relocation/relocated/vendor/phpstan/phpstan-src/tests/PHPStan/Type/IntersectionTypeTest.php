<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\Test\ClassWithToString;
class IntersectionTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataAccepts() : \Iterator
    {
        $intersectionType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Collection'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item'))]);
        (yield [$intersectionType, $intersectionType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Collection'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$intersectionType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\Test\ClassWithToString::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo')]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsCallable() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('Closure'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('bind')]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item'))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item'))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item'))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsCallable
     * @param IntersectionType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsCallable(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isCallable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isCallable()', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : \Iterator
    {
        $intersectionTypeA = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item'))]);
        (yield [$intersectionTypeA, $intersectionTypeA, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        $intersectionTypeB = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]);
        (yield [$intersectionTypeB, $intersectionTypeB, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('a'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('c')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(3)]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType())]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('a'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('c'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('d'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('e'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('f'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('g'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('h'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('i')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(3), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(3), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(3)]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Traversable::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Traversable::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\TestIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\TestIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class))]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : \Iterator
    {
        $intersectionTypeA = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item'))]);
        (yield [$intersectionTypeA, $intersectionTypeA, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Unknown')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$intersectionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        $intersectionTypeB = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]);
        (yield [$intersectionTypeB, $intersectionTypeB, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        $intersectionTypeC = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]);
        (yield [$intersectionTypeC, $intersectionTypeC, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeC, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeC, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        $intersectionTypeD = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DatePeriod'))]);
        (yield [$intersectionTypeD, $intersectionTypeD, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeD, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$intersectionTypeD, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function testToBooleanCrash() : void
    {
        $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType()]);
        $this->assertSame('bool', $type->toBoolean()->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
}
