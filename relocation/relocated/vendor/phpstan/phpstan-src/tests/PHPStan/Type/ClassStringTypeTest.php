<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
class ClassStringTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\Exception::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\stdClass::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('Nonexistent'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : iterable
    {
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\stdClass::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('NonexistentClass'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\stdClass::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(self::class)]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType(\stdClass::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('Nonexistent')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('Nonexistent'), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('Nonexistent2')]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param \PHPStan\Type\ClassStringType $type
     * @param Type $otherType
     * @param \PHPStan\TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param ClassStringType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
