<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\InaccessibleMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ConstantStringType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType
{
    private const DESCRIBE_LIMIT = 20;
    use ConstantScalarTypeTrait;
    use ConstantScalarToBooleanTrait;
    private string $value;
    private bool $isClassString;
    public function __construct(string $value, bool $isClassString = \false)
    {
        $this->value = $value;
        $this->isClassString = $isClassString;
    }
    public function getValue() : string
    {
        return $this->value;
    }
    public function isClassString() : bool
    {
        return $this->isClassString;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'string';
        }, function () : string {
            if ($this->isClassString) {
                return \var_export($this->value, \true);
            }
            try {
                $truncatedValue = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::truncate($this->value, self::DESCRIBE_LIMIT);
            } catch (\TenantCloud\BetterReflection\Relocated\Nette\Utils\RegexpException $e) {
                $truncatedValue = \substr($this->value, 0, self::DESCRIBE_LIMIT) . "…";
            }
            return \var_export($truncatedValue, \true);
        }, function () : string {
            return \var_export($this->value, \true);
        });
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType) {
            $genericType = $type->getGenericType();
            if ($genericType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
            }
            if ($genericType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($this->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Yes & Maybe.
            if ($isSuperType->yes()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType) {
            $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
            return $broker->hasClass($this->getValue()) ? \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof self) {
            return $this->value === $type->value ? \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($this->value === '') {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        if ($broker->hasFunction(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($this->value), null)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        // 'MyClass::myStaticFunction'
        $matches = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
            }
            $classRef = $broker->getClass($matches[1]);
            if ($classRef->hasMethod($matches[2])) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            if (!$classRef->getNativeReflection()->isFinal()) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        $functionName = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name($this->value);
        if ($broker->hasFunction($functionName, null)) {
            return $broker->getFunction($functionName, null)->getVariants();
        }
        // 'MyClass::myStaticFunction'
        $matches = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
            $classReflection = $broker->getClass($matches[1]);
            if ($classReflection->hasMethod($matches[2])) {
                $method = $classReflection->getMethod($matches[2], $scope);
                if (!$scope->canCallMethod($method)) {
                    return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\InaccessibleMethod($method)];
                }
                return $method->getVariants();
            }
            if (!$classReflection->getNativeReflection()->isFinal()) {
                return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
        }
        throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\is_numeric($this->value)) {
            /** @var mixed $value */
            $value = $this->value;
            $value = +$value;
            if (\is_float($value)) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantFloatType($value);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($value);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toInteger();
    }
    public function toFloat() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toFloat();
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean(\is_numeric($this->getValue()));
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean($offsetType->getValue() < \strlen($this->value));
        }
        return parent::hasOffsetValueType($offsetType);
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($offsetType->getValue() < \strlen($this->value)) {
                return new self($this->value[$offsetType->getValue()]);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        return parent::getOffsetValueType($offsetType);
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && $valueStringType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            $value = $this->value;
            $value[$offsetType->getValue()] = $valueStringType->getValue();
            return new self($value);
        }
        return parent::setOffsetValueType($offsetType, $valueType);
    }
    public function append(self $otherString) : self
    {
        return new self($this->getValue() . $otherString->getValue());
    }
    public function generalize() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($this->isClassString) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
    }
    public function getSmallerType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllGreaterThanOrEqualTo((float) $this->value)];
        if ($this->value === '') {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
        }
        if (!(bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getSmallerOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllGreaterThan((float) $this->value)];
        if (!(bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getGreaterType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllSmallerThanOrEqualTo((float) $this->value)];
        if ((bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    public function getGreaterOrEqualType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedTypes = [\TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::createAllSmallerThan((float) $this->value)];
        if ((bool) $this->value) {
            $subtractedTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::remove(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$subtractedTypes));
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['value'], $properties['isClassString'] ?? \false);
    }
}
