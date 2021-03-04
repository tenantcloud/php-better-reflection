<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
class TestDecimalOperatorTypeSpecifyingExtensionTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataSigilAndSidesProvider
     */
    public function testSupportsMatchingSigilsAndSides(string $sigil, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $leftType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $rightType) : void
    {
        $extension = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TestDecimalOperatorTypeSpecifyingExtension();
        $result = $extension->isOperatorSupported($sigil, $leftType, $rightType);
        self::assertTrue($result);
    }
    public function dataSigilAndSidesProvider() : iterable
    {
        (yield '+' => ['+', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class)]);
        (yield '-' => ['-', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class)]);
        (yield '*' => ['*', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class)]);
        (yield '/' => ['/', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class)]);
    }
    /**
     * @dataProvider dataNotMatchingSidesProvider
     */
    public function testNotSupportsNotMatchingSides(string $sigil, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $leftType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $rightType) : void
    {
        $extension = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TestDecimalOperatorTypeSpecifyingExtension();
        $result = $extension->isOperatorSupported($sigil, $leftType, $rightType);
        self::assertFalse($result);
    }
    public function dataNotMatchingSidesProvider() : iterable
    {
        (yield 'left' => ['+', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class)]);
        (yield 'right' => ['+', new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\stdClass::class)]);
    }
}
