<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType;
abstract class ReflectionType
{
    /** @var bool */
    private $allowsNull;
    protected function __construct(bool $allowsNull)
    {
        $this->allowsNull = $allowsNull;
    }
    /**
     * @param Identifier|Name|NullableType|UnionType $type
     */
    public static function createFromTypeAndReflector($type) : self
    {
        $allowsNull = \false;
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType) {
            $type = $type->type;
            $allowsNull = \true;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier || $type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionNamedType($type, $allowsNull);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionUnionType($type, $allowsNull);
    }
    /**
     * Does the parameter allow null?
     */
    public function allowsNull() : bool
    {
        return $this->allowsNull;
    }
    /**
     * Convert this string type to a string
     */
    public abstract function __toString() : string;
}
