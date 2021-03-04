<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType $compoundType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $otherType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
