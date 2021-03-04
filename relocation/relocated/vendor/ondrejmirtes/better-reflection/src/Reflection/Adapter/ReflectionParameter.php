<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter;

use Exception;
use ReflectionParameter as CoreReflectionParameter;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod as BetterReflectionMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter as BetterReflectionParameter;
use function assert;
class ReflectionParameter extends \ReflectionParameter
{
    /** @var BetterReflectionParameter */
    private $betterReflectionParameter;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionParameter $betterReflectionParameter)
    {
        $this->betterReflectionParameter = $betterReflectionParameter;
    }
    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public static function export($function, $parameter, $return = null)
    {
        throw new \Exception('Unable to export statically');
    }
    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->betterReflectionParameter->__toString();
    }
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->betterReflectionParameter->getName();
    }
    /**
     * {@inheritDoc}
     */
    public function isPassedByReference()
    {
        return $this->betterReflectionParameter->isPassedByReference();
    }
    /**
     * {@inheritDoc}
     */
    public function canBePassedByValue()
    {
        return $this->betterReflectionParameter->canBePassedByValue();
    }
    /**
     * {@inheritDoc}
     */
    public function getDeclaringFunction()
    {
        $function = $this->betterReflectionParameter->getDeclaringFunction();
        \assert($function instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod || $function instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunction);
        if ($function instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionMethod($function);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionFunction($function);
    }
    /**
     * {@inheritDoc}
     */
    public function getDeclaringClass()
    {
        $declaringClass = $this->betterReflectionParameter->getDeclaringClass();
        if ($declaringClass === null) {
            return null;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass($declaringClass);
    }
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        $class = $this->betterReflectionParameter->getClass();
        if ($class === null) {
            return null;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClass($class);
    }
    /**
     * {@inheritDoc}
     */
    public function isArray()
    {
        return $this->betterReflectionParameter->isArray();
    }
    /**
     * {@inheritDoc}
     */
    public function isCallable()
    {
        return $this->betterReflectionParameter->isCallable();
    }
    /**
     * {@inheritDoc}
     */
    public function allowsNull()
    {
        return $this->betterReflectionParameter->allowsNull();
    }
    /**
     * {@inheritDoc}
     */
    public function getPosition()
    {
        return $this->betterReflectionParameter->getPosition();
    }
    /**
     * {@inheritDoc}
     */
    public function isOptional()
    {
        return $this->betterReflectionParameter->isOptional();
    }
    /**
     * {@inheritDoc}
     */
    public function isVariadic()
    {
        return $this->betterReflectionParameter->isVariadic();
    }
    /**
     * {@inheritDoc}
     */
    public function isDefaultValueAvailable()
    {
        return $this->betterReflectionParameter->isDefaultValueAvailable();
    }
    /**
     * {@inheritDoc}
     */
    public function getDefaultValue()
    {
        return $this->betterReflectionParameter->getDefaultValue();
    }
    /**
     * {@inheritDoc}
     */
    public function isDefaultValueConstant()
    {
        return $this->betterReflectionParameter->isDefaultValueConstant();
    }
    public function isPromoted() : bool
    {
        return $this->betterReflectionParameter->isPromoted();
    }
    /**
     * {@inheritDoc}
     */
    public function getDefaultValueConstantName()
    {
        return $this->betterReflectionParameter->getDefaultValueConstantName();
    }
    /**
     * {@inheritDoc}
     */
    public function hasType()
    {
        return $this->betterReflectionParameter->hasType();
    }
    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionType::fromReturnTypeOrNull($this->betterReflectionParameter->getType());
    }
}
