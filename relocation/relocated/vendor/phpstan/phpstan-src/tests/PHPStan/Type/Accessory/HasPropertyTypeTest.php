<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class HasPropertyTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('format'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('format'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('format'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('FORMAT'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateInterval::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('UnknownClass'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Closure::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('bar'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasOffsetType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateInterval::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('UnknownClass')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('UnknownClass'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param HasPropertyType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('bar')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('d'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\DateInterval::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param HasPropertyType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param HasPropertyType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
