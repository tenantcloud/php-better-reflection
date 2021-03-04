<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\InaccessibleMethod;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use function array_unique;
class ConstantArrayType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType
{
    private const DESCRIBE_LIMIT = 8;
    /** @var array<int, ConstantIntegerType|ConstantStringType> */
    private array $keyTypes;
    /** @var array<int, Type> */
    private array $valueTypes;
    private int $nextAutoIndex;
    /** @var int[] */
    private array $optionalKeys;
    /** @var self[]|null */
    private ?array $allArrays = null;
    /**
     * @param array<int, ConstantIntegerType|ConstantStringType> $keyTypes
     * @param array<int, Type> $valueTypes
     * @param int $nextAutoIndex
     * @param int[] $optionalKeys
     */
    public function __construct(array $keyTypes, array $valueTypes, int $nextAutoIndex = 0, array $optionalKeys = [])
    {
        \assert(\count($keyTypes) === \count($valueTypes));
        parent::__construct(\count($keyTypes) > 0 ? \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$keyTypes) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType(), \count($valueTypes) > 0 ? \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$valueTypes) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType());
        $this->keyTypes = $keyTypes;
        $this->valueTypes = $valueTypes;
        $this->nextAutoIndex = $nextAutoIndex;
        $this->optionalKeys = $optionalKeys;
    }
    public function isEmpty() : bool
    {
        return \count($this->keyTypes) === 0;
    }
    public function getNextAutoIndex() : int
    {
        return $this->nextAutoIndex;
    }
    /**
     * @return int[]
     */
    public function getOptionalKeys() : array
    {
        return $this->optionalKeys;
    }
    /**
     * @return self[]
     */
    public function getAllArrays() : array
    {
        if ($this->allArrays !== null) {
            return $this->allArrays;
        }
        if (\count($this->optionalKeys) <= 10) {
            $optionalKeysCombinations = $this->powerSet($this->optionalKeys);
        } else {
            $optionalKeysCombinations = [[], $this->optionalKeys];
        }
        $requiredKeys = [];
        foreach (\array_keys($this->keyTypes) as $i) {
            if (\in_array($i, $this->optionalKeys, \true)) {
                continue;
            }
            $requiredKeys[] = $i;
        }
        $arrays = [];
        foreach ($optionalKeysCombinations as $combination) {
            $keys = \array_merge($requiredKeys, $combination);
            $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($keys as $i) {
                $builder->setOffsetValueType($this->keyTypes[$i], $this->valueTypes[$i]);
            }
            $array = $builder->getArray();
            if (!$array instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $arrays[] = $array;
        }
        return $this->allArrays = $arrays;
    }
    /**
     * @template T
     * @param T[] $in
     * @return T[][]
     */
    private function powerSet(array $in) : array
    {
        $count = \count($in);
        $members = \pow(2, $count);
        $return = [];
        for ($i = 0; $i < $members; $i++) {
            $b = \sprintf('%0' . $count . 'b', $i);
            $out = [];
            for ($j = 0; $j < $count; $j++) {
                if ($b[$j] !== '1') {
                    continue;
                }
                $out[] = $in[$j];
            }
            $return[] = $out;
        }
        return $return;
    }
    public function getKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($this->keyTypes) > 1) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType($this->keyTypes);
        }
        return parent::getKeyType();
    }
    /**
     * @return array<int, ConstantIntegerType|ConstantStringType>
     */
    public function getKeyTypes() : array
    {
        return $this->keyTypes;
    }
    /**
     * @return array<int, Type>
     */
    public function getValueTypes() : array
    {
        return $this->valueTypes;
    }
    public function isOptionalKey(int $i) : bool
    {
        return \in_array($i, $this->optionalKeys, \true);
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof self && \count($this->keyTypes) === 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createFromBoolean(\count($type->keyTypes) === 0);
        }
        $result = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        foreach ($this->keyTypes as $i => $keyType) {
            $valueType = $this->valueTypes[$i];
            $hasOffset = $type->hasOffsetValueType($keyType);
            if ($hasOffset->no()) {
                if ($this->isOptionalKey($i)) {
                    continue;
                }
                return $hasOffset;
            }
            if ($hasOffset->maybe() && $this->isOptionalKey($i)) {
                $hasOffset = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            $result = $result->and($hasOffset);
            $otherValueType = $type->getOffsetValueType($keyType);
            $acceptsValue = $valueType->accepts($otherValueType, $strictTypes);
            if ($acceptsValue->no()) {
                return $acceptsValue;
            }
            $result = $result->and($acceptsValue);
        }
        return $result->and($type->isArray());
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            if (\count($this->keyTypes) === 0) {
                if (\count($type->keyTypes) > 0) {
                    if (\count($type->optionalKeys) > 0) {
                        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
                    }
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
                }
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            $results = [];
            foreach ($this->keyTypes as $i => $keyType) {
                $hasOffset = $type->hasOffsetValueType($keyType);
                if ($hasOffset->no()) {
                    if (!$this->isOptionalKey($i)) {
                        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
                    }
                    $results[] = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
                    continue;
                }
                $results[] = $this->valueTypes[$i]->isSuperTypeOf($type->getOffsetValueType($keyType));
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()->and(...$results);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
            $result = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
            if (\count($this->keyTypes) === 0) {
                return $result;
            }
            return $result->and($this->getKeyType()->isSuperTypeOf($type->getKeyType()), $this->getItemType()->isSuperTypeOf($type->getItemType()));
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if (\count($this->keyTypes) !== \count($type->keyTypes)) {
            return \false;
        }
        foreach ($this->keyTypes as $i => $keyType) {
            $valueType = $this->valueTypes[$i];
            if (!$valueType->equals($type->valueTypes[$i])) {
                return \false;
            }
            if (!$keyType->equals($type->keyTypes[$i])) {
                return \false;
            }
        }
        if ($this->optionalKeys !== $type->optionalKeys) {
            return \false;
        }
        return \true;
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $typeAndMethod = $this->findTypeAndMethodName();
        if ($typeAndMethod === null) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return $typeAndMethod->getCertainty();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        $typeAndMethodName = $this->findTypeAndMethodName();
        if ($typeAndMethodName === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if ($typeAndMethodName->isUnknown() || !$typeAndMethodName->getCertainty()->yes()) {
            return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        $method = $typeAndMethodName->getType()->getMethod($typeAndMethodName->getMethod(), $scope);
        if (!$scope->canCallMethod($method)) {
            return [new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\InaccessibleMethod($method)];
        }
        return $method->getVariants();
    }
    public function findTypeAndMethodName() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeAndMethod
    {
        if (\count($this->keyTypes) !== 2) {
            return null;
        }
        if ($this->keyTypes[0]->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(0))->no()) {
            return null;
        }
        if ($this->keyTypes[1]->isSuperTypeOf(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType(1))->no()) {
            return null;
        }
        [$classOrObject, $method] = $this->valueTypes;
        if (!$method instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createUnknown();
        }
        if ($classOrObject instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($classOrObject->getValue())) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createUnknown();
            }
            $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($broker->getClass($classOrObject->getValue())->getName());
        } elseif ($classOrObject instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType) {
            $type = $classOrObject->getGenericType();
        } elseif ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($classOrObject)->yes()) {
            $type = $classOrObject;
        } else {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createUnknown();
        }
        $has = $type->hasMethod($method->getValue());
        if (!$has->no()) {
            if ($this->isOptionalKey(0) || $this->isOptionalKey(1)) {
                $has = $has->and(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createConcrete($type, $method->getValue(), $has);
        }
        return null;
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $offsetType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType::castToArrayKeyType($offsetType);
        if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            $results = [];
            foreach ($offsetType->getTypes() as $innerType) {
                $results[] = $this->hasOffsetValueType($innerType);
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::extremeIdentity(...$results);
        }
        $result = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        foreach ($this->keyTypes as $i => $keyType) {
            if ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType && $offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType && !$offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
            }
            $has = $keyType->isSuperTypeOf($offsetType);
            if ($has->yes()) {
                if ($this->isOptionalKey($i)) {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
                }
                return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            }
            if (!$has->maybe()) {
                continue;
            }
            $result = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        return $result;
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $offsetType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType::castToArrayKeyType($offsetType);
        $matchingValueTypes = [];
        foreach ($this->keyTypes as $i => $keyType) {
            if ($keyType->isSuperTypeOf($offsetType)->no()) {
                continue;
            }
            $matchingValueTypes[] = $this->valueTypes[$i];
        }
        if (\count($matchingValueTypes) > 0) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$matchingValueTypes);
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
            }
            return $type;
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        // undefined offset
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType, bool $unionValues = \false) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createFromConstantArray($this);
        $builder->setOffsetValueType($offsetType, $valueType);
        return $builder->getArray();
    }
    public function unsetOffset(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $offsetType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType::castToArrayKeyType($offsetType);
        if ($offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType || $offsetType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
            foreach ($this->keyTypes as $i => $keyType) {
                if ($keyType->getValue() === $offsetType->getValue()) {
                    $keyTypes = $this->keyTypes;
                    unset($keyTypes[$i]);
                    $valueTypes = $this->valueTypes;
                    unset($valueTypes[$i]);
                    $newKeyTypes = [];
                    $newValueTypes = [];
                    $newOptionalKeys = [];
                    $k = 0;
                    foreach ($keyTypes as $j => $newKeyType) {
                        $newKeyTypes[] = $newKeyType;
                        $newValueTypes[] = $valueTypes[$j];
                        if (\in_array($j, $this->optionalKeys, \true)) {
                            $newOptionalKeys[] = $k;
                        }
                        $k++;
                    }
                    return new self($newKeyTypes, $newValueTypes, $this->nextAutoIndex, $newOptionalKeys);
                }
            }
        }
        $arrays = [];
        foreach ($this->getAllArrays() as $tmp) {
            $arrays[] = new self($tmp->keyTypes, $tmp->valueTypes, $tmp->nextAutoIndex, \array_keys($tmp->keyTypes));
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$arrays));
    }
    public function isIterableAtLeastOnce() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $keysCount = \count($this->keyTypes);
        if ($keysCount === 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        $optionalKeysCount = \count($this->optionalKeys);
        if ($optionalKeysCount === 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        if ($optionalKeysCount < $keysCount) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function removeLast() : self
    {
        if (\count($this->keyTypes) === 0) {
            return $this;
        }
        $i = \count($this->keyTypes) - 1;
        $keyTypes = $this->keyTypes;
        $valueTypes = $this->valueTypes;
        $optionalKeys = $this->optionalKeys;
        unset($optionalKeys[$i]);
        $removedKeyType = \array_pop($keyTypes);
        \array_pop($valueTypes);
        $nextAutoindex = $removedKeyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType ? $removedKeyType->getValue() : $this->nextAutoIndex;
        return new self($keyTypes, $valueTypes, $nextAutoindex, \array_values($optionalKeys));
    }
    public function removeFirst() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType
    {
        $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        foreach ($this->keyTypes as $i => $keyType) {
            if ($i === 0) {
                continue;
            }
            $valueType = $this->valueTypes[$i];
            if ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                $keyType = null;
            }
            $builder->setOffsetValueType($keyType, $valueType);
        }
        return $builder->getArray();
    }
    public function slice(int $offset, ?int $limit, bool $preserveKeys = \false) : self
    {
        if (\count($this->keyTypes) === 0) {
            return $this;
        }
        $keyTypes = \array_slice($this->keyTypes, $offset, $limit);
        $valueTypes = \array_slice($this->valueTypes, $offset, $limit);
        if (!$preserveKeys) {
            $i = 0;
            /** @var array<int, ConstantIntegerType|ConstantStringType> $keyTypes */
            $keyTypes = \array_map(static function ($keyType) use(&$i) {
                if ($keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                    $i++;
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($i - 1);
                }
                return $keyType;
            }, $keyTypes);
        }
        /** @var int|float $nextAutoIndex */
        $nextAutoIndex = 0;
        foreach ($keyTypes as $keyType) {
            if (!$keyType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType) {
                continue;
            }
            /** @var int|float $nextAutoIndex */
            $nextAutoIndex = \max($nextAutoIndex, $keyType->getValue() + 1);
        }
        return new self($keyTypes, $valueTypes, (int) $nextAutoIndex, []);
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        return $this->count()->toBoolean();
    }
    public function generalize() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if (\count($this->keyTypes) === 0) {
            return $this;
        }
        $arrayType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($this->getKeyType()), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($this->getItemType()));
        if (\count($this->keyTypes) > \count($this->optionalKeys)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($arrayType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType());
        }
        return $arrayType;
    }
    /**
     * @return self
     */
    public function generalizeValues() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType
    {
        $valueTypes = [];
        foreach ($this->valueTypes as $valueType) {
            $valueTypes[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::generalizeType($valueType);
        }
        return new self($this->keyTypes, $valueTypes, $this->nextAutoIndex, $this->optionalKeys);
    }
    /**
     * @return self
     */
    public function getKeysArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType
    {
        $keyTypes = [];
        $valueTypes = [];
        $optionalKeys = [];
        $autoIndex = 0;
        foreach ($this->keyTypes as $i => $keyType) {
            $keyTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($i);
            $valueTypes[] = $keyType;
            $autoIndex++;
            if (!$this->isOptionalKey($i)) {
                continue;
            }
            $optionalKeys[] = $i;
        }
        return new self($keyTypes, $valueTypes, $autoIndex, $optionalKeys);
    }
    /**
     * @return self
     */
    public function getValuesArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType
    {
        $keyTypes = [];
        $valueTypes = [];
        $optionalKeys = [];
        $autoIndex = 0;
        foreach ($this->valueTypes as $i => $valueType) {
            $keyTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($i);
            $valueTypes[] = $valueType;
            $autoIndex++;
            if (!$this->isOptionalKey($i)) {
                continue;
            }
            $optionalKeys[] = $i;
        }
        return new self($keyTypes, $valueTypes, $autoIndex, $optionalKeys);
    }
    public function count() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $optionalKeysCount = \count($this->optionalKeys);
        $totalKeysCount = \count($this->getKeyTypes());
        if ($optionalKeysCount === 0) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType($totalKeysCount);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval($totalKeysCount - $optionalKeysCount, $totalKeysCount);
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        $describeValue = function (bool $truncate) use($level) : string {
            $items = [];
            $values = [];
            $exportValuesOnly = \true;
            foreach ($this->keyTypes as $i => $keyType) {
                $valueType = $this->valueTypes[$i];
                if ($keyType->getValue() !== $i) {
                    $exportValuesOnly = \false;
                }
                $isOptional = $this->isOptionalKey($i);
                if ($isOptional) {
                    $exportValuesOnly = \false;
                }
                $items[] = \sprintf('%s%s => %s', $isOptional ? '?' : '', \var_export($keyType->getValue(), \true), $valueType->describe($level));
                $values[] = $valueType->describe($level);
            }
            $append = '';
            if ($truncate && \count($items) > self::DESCRIBE_LIMIT) {
                $items = \array_slice($items, 0, self::DESCRIBE_LIMIT);
                $values = \array_slice($values, 0, self::DESCRIBE_LIMIT);
                $append = ', ...';
            }
            return \sprintf('array(%s%s)', \implode(', ', $exportValuesOnly ? $values : $items), $append);
        };
        return $level->handle(function () use($level) : string {
            return parent::describe($level);
        }, static function () use($describeValue) : string {
            return $describeValue(\true);
        }, static function () use($describeValue) : string {
            return $describeValue(\false);
        });
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof self) {
            $typeMap = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
            foreach ($this->keyTypes as $i => $keyType) {
                $valueType = $this->valueTypes[$i];
                if ($receivedType->hasOffsetValueType($keyType)->no()) {
                    continue;
                }
                $receivedValueType = $receivedType->getOffsetValueType($keyType);
                $typeMap = $typeMap->union($valueType->inferTemplateTypes($receivedValueType));
            }
            return $typeMap;
        }
        return parent::inferTemplateTypes($receivedType);
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $variance = $positionVariance->compose(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        $references = [];
        foreach ($this->keyTypes as $type) {
            foreach ($type->getReferencedTemplateTypes($variance) as $reference) {
                $references[] = $reference;
            }
        }
        foreach ($this->valueTypes as $type) {
            foreach ($type->getReferencedTemplateTypes($variance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $valueTypes = [];
        $stillOriginal = \true;
        foreach ($this->valueTypes as $valueType) {
            $transformedValueType = $cb($valueType);
            if ($transformedValueType !== $valueType) {
                $stillOriginal = \false;
            }
            $valueTypes[] = $transformedValueType;
        }
        if ($stillOriginal) {
            return $this;
        }
        return new self($this->keyTypes, $valueTypes, $this->nextAutoIndex, $this->optionalKeys);
    }
    public function isKeysSupersetOf(self $otherArray) : bool
    {
        if (\count($this->keyTypes) === 0) {
            return \count($otherArray->keyTypes) === 0;
        }
        if (\count($otherArray->keyTypes) === 0) {
            return \false;
        }
        $otherKeys = $otherArray->keyTypes;
        foreach ($this->keyTypes as $keyType) {
            foreach ($otherArray->keyTypes as $j => $otherKeyType) {
                if (!$keyType->equals($otherKeyType)) {
                    continue;
                }
                unset($otherKeys[$j]);
                continue 2;
            }
        }
        return \count($otherKeys) === 0;
    }
    public function mergeWith(self $otherArray) : self
    {
        // only call this after verifying isKeysSupersetOf
        $valueTypes = $this->valueTypes;
        $optionalKeys = $this->optionalKeys;
        foreach ($this->keyTypes as $i => $keyType) {
            $otherIndex = $otherArray->getKeyIndex($keyType);
            if ($otherIndex === null) {
                $optionalKeys[] = $i;
                continue;
            }
            if ($otherArray->isOptionalKey($otherIndex)) {
                $optionalKeys[] = $i;
            }
            $otherValueType = $otherArray->valueTypes[$otherIndex];
            $valueTypes[$i] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($valueTypes[$i], $otherValueType);
        }
        $optionalKeys = \array_values(\array_unique($optionalKeys));
        return new self($this->keyTypes, $valueTypes, $this->nextAutoIndex, $optionalKeys);
    }
    /**
     * @param ConstantIntegerType|ConstantStringType $otherKeyType
     * @return int|null
     */
    private function getKeyIndex($otherKeyType) : ?int
    {
        foreach ($this->keyTypes as $i => $keyType) {
            if ($keyType->equals($otherKeyType)) {
                return $i;
            }
        }
        return null;
    }
    public function makeOffsetRequired(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : self
    {
        $offsetType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType::castToArrayKeyType($offsetType);
        $optionalKeys = $this->optionalKeys;
        foreach ($this->keyTypes as $i => $keyType) {
            if (!$keyType->equals($offsetType)) {
                continue;
            }
            foreach ($optionalKeys as $j => $key) {
                if ($i === $key) {
                    unset($optionalKeys[$j]);
                    return new self($this->keyTypes, $this->valueTypes, $this->nextAutoIndex, \array_values($optionalKeys));
                }
            }
            break;
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['keyTypes'], $properties['valueTypes'], $properties['nextAutoIndex'], $properties['optionalKeys'] ?? []);
    }
}
