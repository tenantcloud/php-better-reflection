<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface PropertyReflection extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function getWritableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
}
