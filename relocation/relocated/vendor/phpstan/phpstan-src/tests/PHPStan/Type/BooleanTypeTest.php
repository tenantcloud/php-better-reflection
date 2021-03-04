<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
class BooleanTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataAccepts() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param BooleanType  $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : iterable
    {
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param BooleanType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param BooleanType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
