<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class TemplateTypeVariance
{
    private const INVARIANT = 1;
    private const COVARIANT = 2;
    private const CONTRAVARIANT = 3;
    private const STATIC = 4;
    /** @var self[] */
    private static array $registry;
    private int $value;
    private function __construct(int $value)
    {
        $this->value = $value;
    }
    private static function create(int $value) : self
    {
        self::$registry[$value] = self::$registry[$value] ?? new self($value);
        return self::$registry[$value];
    }
    public static function createInvariant() : self
    {
        return self::create(self::INVARIANT);
    }
    public static function createCovariant() : self
    {
        return self::create(self::COVARIANT);
    }
    public static function createContravariant() : self
    {
        return self::create(self::CONTRAVARIANT);
    }
    public static function createStatic() : self
    {
        return self::create(self::STATIC);
    }
    public function invariant() : bool
    {
        return $this->value === self::INVARIANT;
    }
    public function covariant() : bool
    {
        return $this->value === self::COVARIANT;
    }
    public function contravariant() : bool
    {
        return $this->value === self::CONTRAVARIANT;
    }
    public function static() : bool
    {
        return $this->value === self::STATIC;
    }
    public function compose(self $other) : self
    {
        if ($this->contravariant()) {
            if ($other->contravariant()) {
                return self::createCovariant();
            }
            if ($other->covariant()) {
                return self::createContravariant();
            }
            return self::createInvariant();
        }
        if ($this->covariant()) {
            if ($other->contravariant()) {
                return self::createCovariant();
            }
            if ($other->covariant()) {
                return self::createCovariant();
            }
            return self::createInvariant();
        }
        return $other;
    }
    public function isValidVariance(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $a, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $b) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$a instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType) {
            $results = [];
            foreach ($b->getTypes() as $innerType) {
                $results[] = $this->isValidVariance($a, $innerType);
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::maxMin(...$results);
        }
        if ($b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$b instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($this->invariant()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($a->equals($b));
        }
        if ($this->covariant()) {
            return $a->isSuperTypeOf($b);
        }
        if ($this->contravariant()) {
            return $b->isSuperTypeOf($a);
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function equals(self $other) : bool
    {
        return $other->value === $this->value;
    }
    public function validPosition(self $other) : bool
    {
        return $other->value === $this->value || $other->invariant() || $this->static();
    }
    public function describe() : string
    {
        switch ($this->value) {
            case self::INVARIANT:
                return 'invariant';
            case self::COVARIANT:
                return 'covariant';
            case self::CONTRAVARIANT:
                return 'contravariant';
            case self::STATIC:
                return 'static';
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    /**
     * @param array{value: int} $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['value']);
    }
}
