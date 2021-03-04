<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ConstantFloatTypeTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\TestCase
{
    public function dataDescribe() : array
    {
        return [[new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(2.0), '2.0'], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(2.0123), '2.0123'], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(1.2000000992884E-10), '1.2000000992884E-10'], [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType(1.2 * 1.4), '1.68']];
    }
    /**
     * @dataProvider dataDescribe
     * @param ConstantFloatType $type
     * @param string $expectedDescription
     */
    public function testDescribe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType $type, string $expectedDescription) : void
    {
        $this->assertSame($expectedDescription, $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()));
    }
}
