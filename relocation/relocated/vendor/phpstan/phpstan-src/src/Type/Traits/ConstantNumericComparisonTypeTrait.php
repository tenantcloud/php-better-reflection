<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
trait ConstantNumericComparisonTypeTrait
{
    public function getSmallerType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllGreaterThanOrEqualTo($this->value)];
        if (!(bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getSmallerOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllGreaterThan($this->value)];
        if (!(bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getGreaterType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllSmallerThanOrEqualTo($this->value)];
        if ((bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getGreaterOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllSmallerThan($this->value)];
        if ((bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
}
