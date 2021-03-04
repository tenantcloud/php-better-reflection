<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
/**
 * Template type strategy suitable for return type acceptance contexts
 */
class TemplateTypeArgumentStrategy implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType $left, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $right, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($right instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            foreach ($right->getTypes() as $type) {
                if ($this->accepts($left, $type, $strictTypes)->yes()) {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($left->equals($right))->or(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($right->equals(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType())));
    }
    public function isArgument() : bool
    {
        return \true;
    }
    /**
     * @param mixed[] $properties
     */
    public static function __set_state(array $properties) : self
    {
        return new self();
    }
}
