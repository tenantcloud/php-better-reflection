<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ObjectTypeMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\NonGenericTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ObjectType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\SubtractableType
{
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    private const EXTRA_OFFSET_CLASSES = ['SimpleXMLElement', 'DOMNodeList', 'Threaded'];
    private string $className;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType $genericObjectType = null;
    /** @var array<string, array<string, \PHPStan\TrinaryLogic>> */
    private static array $superTypes = [];
    public function __construct(string $className, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType = null, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        if ($subtractedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->className = $className;
        $this->subtractedType = $subtractedType;
        $this->classReflection = $classReflection;
    }
    private static function createFromReflection(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $reflection) : self
    {
        if (!$reflection->isGeneric()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($reflection->getName());
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($reflection->getName(), $reflection->typeMapToList($reflection->getActiveTemplateTypeMap()));
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function hasProperty(string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasProperty($propertyName)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        if ($classReflection->isGeneric() && static::class === self::class) {
            return $this->getGenericObjectType()->getProperty($propertyName, $scope);
        }
        return $classReflection->getProperty($propertyName, $scope);
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [$this->className];
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
            return $this->checkSubclassAcceptability($type->getBaseClass());
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType) {
            return $this->isInstanceOf(\Closure::class);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return $this->checkSubclassAcceptability($type->getClassName());
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if (static::class === self::class) {
            $thisDescription = $this->describeCache();
        } else {
            $thisDescription = $this->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::cache());
        }
        if (\get_class($type) === self::class) {
            /** @var self $type */
            $description = $type->describeCache();
        } else {
            $description = $type->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::cache());
        }
        if (isset(self::$superTypes[$thisDescription][$description])) {
            return self::$superTypes[$thisDescription][$description];
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return self::$superTypes[$thisDescription][$description] = $type->isSubTypeOf($this);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType) {
            if ($type->getSubtractedType() !== null) {
                $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
                if ($isSuperType->yes()) {
                    return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
                }
            }
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($type);
            if ($isSuperType->yes()) {
                return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\SubtractableType && $type->getSubtractedType() !== null) {
            $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
            if ($isSuperType->yes()) {
                return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
        }
        $thisClassName = $this->className;
        $thatClassName = $type->getClassName();
        if ($thatClassName === $thisClassName) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClassName)) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        $thisClassReflection = $this->getClassReflection();
        $thatClassReflection = $broker->getClass($thatClassName);
        if ($thisClassReflection->getName() === $thatClassReflection->getName()) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($thatClassReflection->isSubclassOf($thisClassName)) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisClassReflection->isSubclassOf($thatClassName)) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thisClassReflection->isInterface() && !$thatClassReflection->getNativeReflection()->isFinal()) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thatClassReflection->isInterface() && !$thisClassReflection->getNativeReflection()->isFinal()) {
            return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return self::$superTypes[$thisDescription][$description] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if ($this->className !== $type->className) {
            return \false;
        }
        if ($this->subtractedType === null) {
            if ($type->subtractedType === null) {
                return \true;
            }
            return \false;
        }
        if ($type->subtractedType === null) {
            return \false;
        }
        return $this->subtractedType->equals($type->subtractedType);
    }
    protected function checkSubclassAcceptability(string $thatClass) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($this->className === $thatClass) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClass)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        $thisReflection = $this->getClassReflection();
        $thatReflection = $broker->getClass($thatClass);
        if ($thisReflection->getName() === $thatReflection->getName()) {
            // class alias
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisReflection->isInterface() && $thatReflection->isInterface()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->implementsInterface($this->className));
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->isSubclassOf($this->className));
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        $preciseNameCallback = function () : string {
            $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($this->className)) {
                return $this->className;
            }
            return $broker->getClassName($this->className);
        };
        return $level->handle($preciseNameCallback, $preciseNameCallback, function () use($level) : string {
            $description = $this->className;
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            return $description;
        });
    }
    private function describeCache() : string
    {
        $description = $this->className;
        if ($this->subtractedType !== null) {
            $description .= \sprintf('~%s', $this->subtractedType->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::cache()));
        }
        return $description;
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType()]);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        if (\in_array($this->getClassName(), ['CurlHandle', 'CurlMultiHandle'], \true)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        if ($classReflection->hasNativeMethod('__toString')) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__toString')->getVariants())->getReturnType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        }
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        if (!$classReflection->getNativeReflection()->isUserDefined() || \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension::isUniversalObjectCrate($broker, $broker->getUniversalObjectCratesClasses(), $classReflection)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        }
        $arrayKeys = [];
        $arrayValues = [];
        do {
            foreach ($classReflection->getNativeReflection()->getProperties() as $nativeProperty) {
                if ($nativeProperty->isStatic()) {
                    continue;
                }
                $declaringClass = $broker->getClass($nativeProperty->getDeclaringClass()->getName());
                $property = $declaringClass->getNativeProperty($nativeProperty->getName());
                $keyName = $nativeProperty->getName();
                if ($nativeProperty->isPrivate()) {
                    $keyName = \sprintf("\0%s\0%s", $declaringClass->getName(), $keyName);
                } elseif ($nativeProperty->isProtected()) {
                    $keyName = \sprintf("\0*\0%s", $keyName);
                }
                $arrayKeys[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType($keyName);
                $arrayValues[] = $property->getReadableType();
            }
            $classReflection = $classReflection->getParentClass();
        } while ($classReflection !== \false);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType($arrayKeys, $arrayValues);
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
    }
    public function canAccessProperties() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function canCallMethods() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if (\strtolower($this->className) === 'stdclass') {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasMethod($methodName)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        if ($classReflection->isGeneric() && static::class === self::class) {
            return $this->getGenericObjectType()->getMethod($methodName, $scope);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ObjectTypeMethodReflection($this, $classReflection->getMethod($methodName, $scope));
    }
    private function getGenericObjectType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null || !$classReflection->isGeneric()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if ($this->genericObjectType === null) {
            $this->genericObjectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($this->className, \array_values($classReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()), $this->subtractedType);
        }
        return $this->genericObjectType;
    }
    public function canAccessConstants() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($class->hasConstant($constantName));
    }
    public function getConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        return $class->getConstant($constantName);
    }
    public function isIterable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class);
    }
    public function isIterableAtLeastOnce() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class)->and(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getIterableKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('key')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            $keyType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableKeyType();
            });
            if (!$keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType || $keyType->isExplicitMixed()) {
                return $keyType;
            }
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tKey = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TKey');
            if ($tKey !== null) {
                return $tKey;
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('current')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            $valueType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableValueType();
            });
            if (!$valueType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType || $valueType->isExplicitMixed()) {
                return $valueType;
            }
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tValue = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TValue');
            if ($tValue !== null) {
                return $tValue;
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    private function isExtraOffsetAccessibleClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        foreach (self::EXTRA_OFFSET_CLASSES as $extraOffsetClass) {
            if ($classReflection->getName() === $extraOffsetClass) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            if ($classReflection->isSubclassOf($extraOffsetClass)) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
        }
        if ($classReflection->isInterface()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isFinal()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isOffsetAccessible() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\ArrayAccess::class)->or($this->isExtraOffsetAccessibleClass());
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $acceptedOffsetType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\RecursionGuard::run($this, function () use($classReflection) : Type {
                $parameters = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                return $offsetParameter->getType();
            });
            if ($acceptedOffsetType->isSuperTypeOf($offsetType)->no()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->isExtraOffsetAccessibleClass()->and(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        if (!$this->isExtraOffsetAccessibleClass()->no()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetGet')->getVariants())->getReturnType();
            });
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->isOffsetAccessible()->no()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $classReflection = $this->getClassReflection();
            if ($classReflection === null) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            }
            $acceptedValueType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType();
            $acceptedOffsetType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\RecursionGuard::run($this, function () use($classReflection, &$acceptedValueType) : Type {
                $parameters = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                $acceptedValueType = $parameters[1]->getType();
                return $offsetParameter->getType();
            });
            if ($offsetType === null) {
                $offsetType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            }
            if (!$offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$acceptedOffsetType->isSuperTypeOf($offsetType)->yes() || !$valueType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$acceptedValueType->isSuperTypeOf($valueType)->yes()) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            }
        }
        // in the future we may return intersection of $this and OffsetAccessibleType()
        return $this;
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        if (\count($parametersAcceptors) === 1 && $parametersAcceptors[0] instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->className === \Closure::class) {
            return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $parametersAcceptors;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]|null
     */
    private function findCallableParametersAcceptors() : ?array
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        if ($classReflection->hasNativeMethod('__invoke')) {
            return $classReflection->getNativeMethod('__invoke')->getVariants();
        }
        if (!$classReflection->getNativeReflection()->isFinal()) {
            return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        return null;
    }
    public function isCloneable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['subtractedType'] ?? null);
    }
    public function isInstanceOf(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isSubclassOf($className) || $classReflection->getName() === $className) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isInterface()) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function subtract(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->subtractedType !== null) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return $this->changeSubtractedType($type);
    }
    public function getTypeWithoutSubtractedType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->changeSubtractedType(null);
    }
    public function changeSubtractedType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($this->className, $subtractedType);
    }
    public function getSubtractedType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedType = $this->subtractedType !== null ? $cb($this->subtractedType) : null;
        if ($subtractedType !== $this->subtractedType) {
            return new self($this->className, $subtractedType);
        }
        return $this;
    }
    public function getClassReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($this->className)) {
            return null;
        }
        $classReflection = $broker->getClass($this->className);
        if ($classReflection->isGeneric()) {
            return $this->classReflection = $classReflection->withTypes(\array_values($classReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()));
        }
        return $this->classReflection = $classReflection;
    }
    /**
     * @param string $className
     * @return self|null
     */
    public function getAncestorWithClassName(string $className) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType
    {
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($className)) {
            return null;
        }
        $theirReflection = $broker->getClass($className);
        $thisReflection = $this->getClassReflection();
        if ($thisReflection === null) {
            return null;
        }
        if ($theirReflection->getName() === $thisReflection->getName()) {
            return $this;
        }
        foreach ($this->getInterfaces() as $interface) {
            $ancestor = $interface->getAncestorWithClassName($className);
            if ($ancestor !== null) {
                return $ancestor;
            }
        }
        $parent = $this->getParent();
        if ($parent !== null) {
            $ancestor = $parent->getAncestorWithClassName($className);
            if ($ancestor !== null) {
                return $ancestor;
            }
        }
        return null;
    }
    private function getParent() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType
    {
        $thisReflection = $this->getClassReflection();
        if ($thisReflection === null) {
            return null;
        }
        $parentReflection = $thisReflection->getParentClass();
        if ($parentReflection === \false) {
            return null;
        }
        return self::createFromReflection($parentReflection);
    }
    /** @return ObjectType[] */
    private function getInterfaces() : array
    {
        $thisReflection = $this->getClassReflection();
        if ($thisReflection === null) {
            return [];
        }
        return \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $interfaceReflection) : self {
            return self::createFromReflection($interfaceReflection);
        }, $thisReflection->getInterfaces());
    }
}
