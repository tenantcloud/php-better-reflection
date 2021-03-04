<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter;

use InvalidArgumentException;
use OutOfBoundsException;
use ReflectionClass as CoreReflectionClass;
use ReflectionException as CoreReflectionException;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnObject;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass as BetterReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant as BetterReflectionClassConstant;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod as BetterReflectionMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionObject as BetterReflectionObject;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty as BetterReflectionProperty;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper;
use function array_combine;
use function array_map;
use function array_values;
use function assert;
use function func_num_args;
use function is_array;
use function is_object;
use function is_string;
use function sprintf;
use function strtolower;
class ReflectionClass extends \ReflectionClass
{
    /** @var BetterReflectionClass */
    private $betterReflectionClass;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $betterReflectionClass)
    {
        $this->betterReflectionClass = $betterReflectionClass;
        unset($this->name);
    }
    public function getBetterReflection() : \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass
    {
        return $this->betterReflectionClass;
    }
    /**
     * {@inheritDoc}
     *
     * @throws CoreReflectionException
     */
    public static function export($argument, $return = \false)
    {
        if (\is_string($argument) || \is_object($argument)) {
            if (\is_string($argument)) {
                $output = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass::createFromName($argument)->__toString();
            } else {
                $output = \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionObject::createFromInstance($argument)->__toString();
            }
            if ($return) {
                return $output;
            }
            echo $output;
            return null;
        }
        throw new \InvalidArgumentException('Class name must be provided');
    }
    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->betterReflectionClass->__toString();
    }
    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        if ($name === 'name') {
            return $this->betterReflectionClass->getName();
        }
        return $this->{$name};
    }
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->betterReflectionClass->getName();
    }
    /**
     * {@inheritDoc}
     */
    public function isAnonymous()
    {
        return $this->betterReflectionClass->isAnonymous();
    }
    /**
     * {@inheritDoc}
     */
    public function isInternal()
    {
        return $this->betterReflectionClass->isInternal();
    }
    /**
     * {@inheritDoc}
     */
    public function isUserDefined()
    {
        return $this->betterReflectionClass->isUserDefined();
    }
    /**
     * {@inheritDoc}
     */
    public function isInstantiable()
    {
        return $this->betterReflectionClass->isInstantiable();
    }
    /**
     * {@inheritDoc}
     */
    public function isCloneable()
    {
        return $this->betterReflectionClass->isCloneable();
    }
    /**
     * {@inheritDoc}
     */
    public function getFileName()
    {
        $fileName = $this->betterReflectionClass->getFileName();
        return $fileName !== null ? \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper::normalizeSystemPath($fileName) : \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getStartLine()
    {
        return $this->betterReflectionClass->getStartLine();
    }
    /**
     * {@inheritDoc}
     */
    public function getEndLine()
    {
        return $this->betterReflectionClass->getEndLine();
    }
    /**
     * {@inheritDoc}
     */
    public function getDocComment()
    {
        return $this->betterReflectionClass->getDocComment() ?: \false;
    }
    /**
     * {@inheritDoc}
     */
    public function getConstructor()
    {
        try {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionMethod($this->betterReflectionClass->getConstructor());
        } catch (\OutOfBoundsException $e) {
            return null;
        }
    }
    /**
     * {@inheritDoc}
     */
    public function hasMethod($name)
    {
        return $this->betterReflectionClass->hasMethod($name);
    }
    /**
     * {@inheritDoc}
     */
    public function getMethod($name)
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionMethod($this->betterReflectionClass->getMethod($name));
    }
    /**
     * {@inheritDoc}
     */
    public function getMethods($filter = null)
    {
        return \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionMethod $method) : ReflectionMethod {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionMethod($method);
        }, $this->betterReflectionClass->getMethods($filter));
    }
    /**
     * {@inheritDoc}
     */
    public function hasProperty($name)
    {
        return $this->betterReflectionClass->hasProperty($name);
    }
    /**
     * {@inheritDoc}
     */
    public function getProperty($name)
    {
        $betterReflectionProperty = $this->betterReflectionClass->getProperty($name);
        if ($betterReflectionProperty === null) {
            throw new \ReflectionException(\sprintf('Property "%s" does not exist', $name));
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionProperty($betterReflectionProperty);
    }
    /**
     * {@inheritDoc}
     */
    public function getProperties($filter = null)
    {
        return \array_values(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $property) : ReflectionProperty {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionProperty($property);
        }, $this->betterReflectionClass->getProperties($filter)));
    }
    /**
     * {@inheritDoc}
     */
    public function hasConstant($name)
    {
        return $this->betterReflectionClass->hasConstant($name);
    }
    /**
     * {@inheritDoc}
     */
    public function getConstants(int $filter = null)
    {
        return $this->betterReflectionClass->getConstants($filter);
    }
    /**
     * {@inheritDoc}
     */
    public function getConstant($name)
    {
        return $this->betterReflectionClass->getConstant($name);
    }
    /**
     * {@inheritdoc}
     */
    public function getReflectionConstant($name)
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClassConstant($this->betterReflectionClass->getReflectionConstant($name));
    }
    /**
     * {@inheritdoc}
     */
    public function getReflectionConstants(int $filter = null)
    {
        return \array_values(\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant $betterConstant) : ReflectionClassConstant {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionClassConstant($betterConstant);
        }, $this->betterReflectionClass->getReflectionConstants($filter)));
    }
    /**
     * {@inheritDoc}
     */
    public function getInterfaces()
    {
        $interfaces = $this->betterReflectionClass->getInterfaces();
        $wrappedInterfaces = [];
        foreach ($interfaces as $key => $interface) {
            $wrappedInterfaces[$key] = new self($interface);
        }
        return $wrappedInterfaces;
    }
    /**
     * {@inheritDoc}
     */
    public function getInterfaceNames()
    {
        return $this->betterReflectionClass->getInterfaceNames();
    }
    /**
     * {@inheritDoc}
     */
    public function isInterface()
    {
        return $this->betterReflectionClass->isInterface();
    }
    /**
     * {@inheritDoc}
     */
    public function getTraits()
    {
        $traits = $this->betterReflectionClass->getTraits();
        /** @var array<trait-string> $traitNames */
        $traitNames = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $trait) : string {
            return $trait->getName();
        }, $traits);
        $traitsByName = \array_combine($traitNames, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $trait) : self {
            return new self($trait);
        }, $traits));
        \assert(\is_array($traitsByName), \sprintf('Could not create an array<trait-string, ReflectionClass> for class "%s"', $this->betterReflectionClass->getName()));
        return $traitsByName;
    }
    /**
     * {@inheritDoc}
     */
    public function getTraitNames()
    {
        return $this->betterReflectionClass->getTraitNames();
    }
    /**
     * {@inheritDoc}
     */
    public function getTraitAliases()
    {
        return $this->betterReflectionClass->getTraitAliases();
    }
    /**
     * {@inheritDoc}
     */
    public function isTrait()
    {
        return $this->betterReflectionClass->isTrait();
    }
    /**
     * {@inheritDoc}
     */
    public function isAbstract()
    {
        return $this->betterReflectionClass->isAbstract();
    }
    /**
     * {@inheritDoc}
     */
    public function isFinal()
    {
        return $this->betterReflectionClass->isFinal();
    }
    /**
     * {@inheritDoc}
     */
    public function getModifiers()
    {
        return $this->betterReflectionClass->getModifiers();
    }
    /**
     * {@inheritDoc}
     */
    public function isInstance($object)
    {
        try {
            return $this->betterReflectionClass->isInstance($object);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception\NotAnObject $e) {
            return null;
        }
    }
    /**
     * {@inheritDoc}
     */
    public function newInstance($arg = null, ...$args)
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function newInstanceWithoutConstructor()
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function newInstanceArgs(?array $args = null)
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function getParentClass()
    {
        $parentClass = $this->betterReflectionClass->getParentClass();
        if ($parentClass === null) {
            return \false;
        }
        return new self($parentClass);
    }
    /**
     * {@inheritDoc}
     */
    public function isSubclassOf($class)
    {
        $realParentClassNames = $this->betterReflectionClass->getParentClassNames();
        $parentClassNames = \array_combine(\array_map(static function (string $parentClassName) : string {
            return \strtolower($parentClassName);
        }, $realParentClassNames), $realParentClassNames);
        $realParentClassName = $parentClassNames[\strtolower($class)] ?? $class;
        return $this->betterReflectionClass->isSubclassOf($realParentClassName) || $this->implementsInterface($class);
    }
    /**
     * {@inheritDoc}
     */
    public function getStaticProperties()
    {
        return $this->betterReflectionClass->getStaticProperties();
    }
    /**
     * {@inheritDoc}
     */
    public function getStaticPropertyValue($name, $default = null)
    {
        $betterReflectionProperty = $this->betterReflectionClass->getProperty($name);
        if ($betterReflectionProperty === null) {
            if (\func_num_args() === 2) {
                return $default;
            }
            throw new \ReflectionException(\sprintf('Property "%s" does not exist', $name));
        }
        $property = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionProperty($betterReflectionProperty);
        if (!$property->isAccessible()) {
            throw new \ReflectionException(\sprintf('Property "%s" is not accessible', $name));
        }
        if (!$property->isStatic()) {
            throw new \ReflectionException(\sprintf('Property "%s" is not static', $name));
        }
        return $property->getValue();
    }
    /**
     * {@inheritDoc}
     */
    public function setStaticPropertyValue($name, $value)
    {
        $betterReflectionProperty = $this->betterReflectionClass->getProperty($name);
        if ($betterReflectionProperty === null) {
            throw new \ReflectionException(\sprintf('Property "%s" does not exist', $name));
        }
        $property = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\ReflectionProperty($betterReflectionProperty);
        if (!$property->isAccessible()) {
            throw new \ReflectionException(\sprintf('Property "%s" is not accessible', $name));
        }
        if (!$property->isStatic()) {
            throw new \ReflectionException(\sprintf('Property "%s" is not static', $name));
        }
        $property->setValue($value);
    }
    /**
     * {@inheritDoc}
     */
    public function getDefaultProperties()
    {
        return $this->betterReflectionClass->getDefaultProperties();
    }
    /**
     * {@inheritDoc}
     */
    public function isIterateable()
    {
        return $this->betterReflectionClass->isIterateable();
    }
    /**
     * {@inheritDoc}
     */
    public function implementsInterface($interface)
    {
        $realInterfaceNames = $this->betterReflectionClass->getInterfaceNames();
        $interfaceNames = \array_combine(\array_map(static function (string $interfaceName) : string {
            return \strtolower($interfaceName);
        }, $realInterfaceNames), $realInterfaceNames);
        $realInterfaceName = $interfaceNames[\strtolower($interface)] ?? $interface;
        return $this->betterReflectionClass->implementsInterface($realInterfaceName);
    }
    /**
     * {@inheritDoc}
     */
    public function getExtension()
    {
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Adapter\Exception\NotImplemented('Not implemented');
    }
    /**
     * {@inheritDoc}
     */
    public function getExtensionName()
    {
        return $this->betterReflectionClass->getExtensionName() ?? \false;
    }
    /**
     * {@inheritDoc}
     */
    public function inNamespace()
    {
        return $this->betterReflectionClass->inNamespace();
    }
    /**
     * {@inheritDoc}
     */
    public function getNamespaceName()
    {
        return $this->betterReflectionClass->getNamespaceName();
    }
    /**
     * {@inheritDoc}
     */
    public function getShortName()
    {
        return $this->betterReflectionClass->getShortName();
    }
}
