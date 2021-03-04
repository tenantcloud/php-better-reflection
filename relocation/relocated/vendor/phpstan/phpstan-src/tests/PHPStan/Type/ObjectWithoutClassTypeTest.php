<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
class ObjectWithoutClassTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception'), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\InvalidArgumentException::class), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception')), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType('Exception')), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\InvalidArgumentException::class)), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ObjectWithoutClassType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
