<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

interface OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $leftSide, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $rightSide) : bool;
    public function specifyType(string $operatorSigil, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $leftSide, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $rightSide) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
}
