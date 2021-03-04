<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\Test\ClassWithToString;
class StringTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : iterable
    {
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\Test\ClassWithToString::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType('foo')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param \PHPStan\Type\StringType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('foo'), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('foo'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('bar'), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(''), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(''), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param StringType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
