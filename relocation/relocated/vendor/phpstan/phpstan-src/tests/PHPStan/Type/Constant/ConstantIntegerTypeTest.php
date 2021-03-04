<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ConstantIntegerTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataAccepts() : iterable
    {
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param ConstantIntegerType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : iterable
    {
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(2), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ConstantIntegerType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
