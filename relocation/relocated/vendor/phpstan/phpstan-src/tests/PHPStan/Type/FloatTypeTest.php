<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
class FloatTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataAccepts() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ResourceType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType();
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), \true], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(1.0), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0), \false], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(0.0), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType('0.0'), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param FloatType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
