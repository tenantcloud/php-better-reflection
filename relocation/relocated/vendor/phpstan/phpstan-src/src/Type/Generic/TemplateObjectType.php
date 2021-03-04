<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
final class TemplateObjectType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
{
    use UndecidedComparisonCompoundTypeTrait;
    use TemplateTypeTrait {
        isSubTypeOf as isSubTypeOfTrait;
    }
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name, string $class)
    {
        parent::__construct($class);
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($class);
    }
    public function isSubTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        return $this->isSubTypeOfTrait($type);
    }
    public function toArgument() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
    {
        return new self($this->scope, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeArgumentStrategy(), $this->variance, $this->name, $this->getClassName());
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['scope'], $properties['strategy'], $properties['variance'], $properties['name'], $properties['className']);
    }
}
