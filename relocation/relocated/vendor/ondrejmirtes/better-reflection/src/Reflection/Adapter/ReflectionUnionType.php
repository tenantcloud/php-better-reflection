<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter;

use ReflectionUnionType as CoreReflectionUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionUnionType as BetterReflectionType;
use function array_map;
class ReflectionUnionType extends \ReflectionUnionType
{
    /** @var BetterReflectionType */
    private $betterReflectionType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionUnionType $betterReflectionType)
    {
        $this->betterReflectionType = $betterReflectionType;
    }
    public function __toString() : string
    {
        return $this->betterReflectionType->__toString();
    }
    public function allowsNull() : bool
    {
        return $this->betterReflectionType->allowsNull();
    }
    /**
     * @return \ReflectionType[]
     */
    public function getTypes() : array
    {
        return \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionType $type) : \ReflectionType {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionType::fromReturnTypeOrNull($type);
        }, $this->betterReflectionType->getTypes());
    }
}
