<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal;
final class TestDecimalOperatorTypeSpecifyingExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $leftSide, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $rightSide) : bool
    {
        return \in_array($operatorSigil, ['-', '+', '*', '/'], \true) && $leftSide->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class))->yes() && $rightSide->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class))->yes();
    }
    public function specifyType(string $operatorSigil, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $leftSide, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $rightSide) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType(\TenantCloud\BetterReflection\Relocated\PHPStan\Fixture\TestDecimal::class);
    }
}
