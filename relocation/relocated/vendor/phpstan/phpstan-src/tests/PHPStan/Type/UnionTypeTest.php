<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasMethodType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
class UnionTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataIsCallable() : array
    {
        return [[\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('Closure'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('bind')]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('array_push')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Closure')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsCallable
     * @param UnionType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsCallable(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isCallable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isCallable()', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataSelfCompare() : \Iterator
    {
        $broker = $this->createBroker();
        $integerType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        $stringType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
        $mixedType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        $constantStringType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('foo');
        $constantIntegerType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(42);
        $templateTypeScope = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo');
        $mixedParam = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, $mixedType, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        $integerParam = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('n', \false, $integerType, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($integerType, $stringType)]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($stringType, $mixedType)]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([$integerType, $stringType])]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType([$mixedParam, $integerParam], $stringType, \false)]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType([$mixedParam, $integerParam], $stringType, \false)]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([$constantStringType, $constantIntegerType], [$mixedType, $stringType], 10, [1])]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true)]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(3.14)]);
        (yield [$constantIntegerType]);
        (yield [$constantStringType]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class))]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType('Foo', [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')])]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasMethodType('Foo')]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType($constantStringType)]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo')]);
        (yield [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(3, 10)]);
        (yield [$integerType]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasMethodType('Foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('bar')])]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType($integerType, $stringType)]);
        (yield [$mixedType]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Foo')]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Foo'))]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ResourceType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType('Foo')]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StrictMixedType()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType()]);
        (yield [$stringType]);
        (yield [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create($templateTypeScope, 'T', null, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]);
        (yield [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create($templateTypeScope, 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Foo'), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]);
        (yield [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory::create($templateTypeScope, 'T', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType($broker->getClass('Foo'))]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([$integerType, $stringType])]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType()]);
    }
    /**
     * @dataProvider dataSelfCompare
     *
     * @param  Type $type
     */
    public function testSelfCompare(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : void
    {
        $description = $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise());
        $this->assertTrue($type->equals($type), \sprintf('%s -> equals(itself)', $description));
        $this->assertEquals('Yes', $type->isSuperTypeOf($type)->describe(), \sprintf('%s -> isSuperTypeOf(itself)', $description));
        $this->assertInstanceOf(\get_class($type), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($type, $type), \sprintf('%s -> union with itself is same type', $description));
    }
    public function dataIsSuperTypeOf() : \Iterator
    {
        $unionTypeA = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[0], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[1], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, $unionTypeA, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        $unionTypeB = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DatePeriod'))]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DatePeriod'))]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[0], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[1], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, $unionTypeB, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DatePeriod')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Foo'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('DateTime')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param UnionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : \Iterator
    {
        $unionTypeA = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]);
        (yield [$unionTypeA, $unionTypeA, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType(\array_merge($unionTypeA->getTypes(), [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ResourceType()])), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[0], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[1], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        $unionTypeB = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Item'))]);
        (yield [$unionTypeB, $unionTypeB, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType(\array_merge($unionTypeB->getTypes(), [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()])), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[0], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[1], \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('ArrayObject'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Foo'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param UnionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param UnionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataDescribe() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), 'int|string', 'int|string'], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'int|string|null', 'int|string|null'], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('1aaa'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('11aaa'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('2aaa'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('10aaa'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(10), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(2.2), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('10'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('2'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('1')]), "1|2|2.2|10|'1'|'10'|'10aaa'|'11aaa'|'1aaa'|'2'|'2aaa'|'foo'|stdClass|true|null", 'float|int|stdClass|string|true|null'], [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('a'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('a'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('aaa')), '\'aaa\'|array(\'a\' => int|string, \'b\' => bool|float)', 'array<string, bool|float|int|string>|string'], [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('a'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('c')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('aaa')), '\'aaa\'|array(\'a\' => string, \'b\' => bool)|array(\'b\' => int, \'c\' => float)', 'array<string, bool|float|int|string>|string'], [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('a'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('c'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('d')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('aaa')), '\'aaa\'|array(\'a\' => string, \'b\' => bool)|array(\'c\' => int, \'d\' => float)', 'array<string, bool|float|int|string>|string'], [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2)], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()])), 'array(0 => int|string, ?1 => bool, ?2 => float)', 'array<int, bool|float|int|string>'], [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], []), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('foooo')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('barrr')])), 'array()|array(\'foooo\' => \'barrr\')', 'array<string, string>'], [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType()])), 'int|(string&numeric)', 'int|string']];
    }
    /**
     * @dataProvider dataDescribe
     * @param Type $type
     * @param string $expectedValueDescription
     * @param string $expectedTypeOnlyDescription
     */
    public function testDescribe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, string $expectedValueDescription, string $expectedTypeOnlyDescription) : void
    {
        $this->assertSame($expectedValueDescription, $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame($expectedTypeOnlyDescription, $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::typeOnly()));
    }
    public function dataAccepts() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType([], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \false), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType([], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType([], new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \false), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param UnionType $type
     * @param Type $acceptedType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptedType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $this->assertSame($expectedResult->describe(), $type->accepts($acceptedType, \true)->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataHasMethod() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]), 'format', \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTime::class)]), 'format', \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]), 'format', \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), 'format', \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataHasMethod
     * @param UnionType $type
     * @param string $methodName
     * @param TrinaryLogic $expectedResult
     */
    public function testHasMethod(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType $type, string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $this->assertSame($expectedResult->describe(), $type->hasMethod($methodName)->describe());
    }
    public function testSorting() : void
    {
        $types = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(-1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(-1.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(1.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(''), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('a'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('b'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([], []), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('')], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('')]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(10, 20), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(30, 40), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()];
        $type1 = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType($types);
        $type2 = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType(\array_reverse($types));
        $this->assertTrue($type1->equals($type2), 'UnionType sorting always produces the same order');
    }
}
