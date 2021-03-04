<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
final class TemplateBenevolentUnionType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
{
    use TemplateTypeTrait;
    /**
     * @param Type[] $types
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, array $types, string $name)
    {
        parent::__construct($types);
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType($types);
    }
    public function toArgument() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
    {
        return new self($this->scope, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeArgumentStrategy(), $this->variance, $this->getTypes(), $this->name);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['scope'], $properties['strategy'], $properties['variance'], $properties['types'], $properties['name']);
    }
}
