<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface MethodReflection extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection
{
    public function getName() : string;
    public function getPrototype() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection;
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array;
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isFinal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
    public function getThrowType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function hasSideEffects() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
}
