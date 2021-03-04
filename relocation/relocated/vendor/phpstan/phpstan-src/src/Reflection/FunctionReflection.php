<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface FunctionReflection
{
    public function getName() : string;
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
    public function isBuiltin() : bool;
}
