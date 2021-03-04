<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier;

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction;
use function array_key_exists;
use function sprintf;
class IdentifierType
{
    public const IDENTIFIER_CLASS = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass::class;
    public const IDENTIFIER_FUNCTION = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction::class;
    public const IDENTIFIER_CONSTANT = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant::class;
    private const VALID_TYPES = [self::IDENTIFIER_CLASS => null, self::IDENTIFIER_FUNCTION => null, self::IDENTIFIER_CONSTANT => null];
    /** @var string */
    private $name;
    public function __construct(string $type = self::IDENTIFIER_CLASS)
    {
        if (!\array_key_exists($type, self::VALID_TYPES)) {
            throw new \InvalidArgumentException(\sprintf('%s is not a valid identifier type', $type));
        }
        $this->name = $type;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function isClass() : bool
    {
        return $this->name === self::IDENTIFIER_CLASS;
    }
    public function isFunction() : bool
    {
        return $this->name === self::IDENTIFIER_FUNCTION;
    }
    public function isConstant() : bool
    {
        return $this->name === self::IDENTIFIER_CONSTANT;
    }
    /**
     * Check to see if a reflector is of a valid type specified by this identifier.
     */
    public function isMatchingReflector(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Reflection $reflector) : bool
    {
        if ($this->name === self::IDENTIFIER_CLASS) {
            return $reflector instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
        }
        if ($this->name === self::IDENTIFIER_FUNCTION) {
            return $reflector instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction;
        }
        if ($this->name === self::IDENTIFIER_CONSTANT) {
            return $reflector instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant;
        }
        return \false;
    }
}
