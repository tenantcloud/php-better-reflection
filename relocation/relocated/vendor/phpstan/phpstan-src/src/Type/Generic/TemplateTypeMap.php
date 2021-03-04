<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class TemplateTypeMap
{
    private static ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $empty = null;
    /** @var array<string,\PHPStan\Type\Type> */
    private array $types;
    /** @param array<string,\PHPStan\Type\Type> $types */
    public function __construct(array $types)
    {
        $this->types = $types;
    }
    public static function createEmpty() : self
    {
        $empty = self::$empty;
        if ($empty !== null) {
            return $empty;
        }
        $empty = new self([]);
        self::$empty = $empty;
        return $empty;
    }
    public function isEmpty() : bool
    {
        return \count($this->types) === 0;
    }
    public function count() : int
    {
        return \count($this->types);
    }
    /** @return array<string,\PHPStan\Type\Type> */
    public function getTypes() : array
    {
        return $this->types;
    }
    public function getType(string $name) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->types[$name] ?? null;
    }
    public function union(self $other) : self
    {
        $result = $this->types;
        foreach ($other->types as $name => $type) {
            if (isset($result[$name])) {
                $result[$name] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($result[$name], $type);
            } else {
                $result[$name] = $type;
            }
        }
        return new self($result);
    }
    public function benevolentUnion(self $other) : self
    {
        $result = $this->types;
        foreach ($other->types as $name => $type) {
            if (isset($result[$name])) {
                $result[$name] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::toBenevolentUnion(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($result[$name], $type));
            } else {
                $result[$name] = $type;
            }
        }
        return new self($result);
    }
    public function intersect(self $other) : self
    {
        $result = $this->types;
        foreach ($other->types as $name => $type) {
            if (isset($result[$name])) {
                $result[$name] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($result[$name], $type);
            } else {
                $result[$name] = $type;
            }
        }
        return new self($result);
    }
    /** @param callable(string,Type):Type $cb */
    public function map(callable $cb) : self
    {
        $types = [];
        foreach ($this->types as $name => $type) {
            $types[$name] = $cb($name, $type);
        }
        return new self($types);
    }
    public function resolveToBounds() : self
    {
        return $this->map(static function (string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($type);
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && $type->isExplicitMixed()) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\false);
            }
            return $type;
        });
    }
    /**
     * @param mixed[] $properties
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['types']);
    }
}
