<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
final class GenericObjectType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType
{
    /** @var array<int, Type> */
    private array $types;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection;
    /**
     * @param array<int, Type> $types
     */
    public function __construct(string $mainType, array $types, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType = null, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        parent::__construct($mainType, $subtractedType, $classReflection);
        $this->types = $types;
        $this->classReflection = $classReflection;
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), \implode(', ', \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($level) : string {
            return $type->describe($level);
        }, $this->types)));
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if (!parent::equals($type)) {
            return \false;
        }
        if (\count($this->types) !== \count($type->types)) {
            return \false;
        }
        foreach ($this->types as $i => $genericType) {
            $otherGenericType = $type->types[$i];
            if (!$genericType->equals($otherGenericType)) {
                return \false;
            }
        }
        return \true;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        $classes = parent::getReferencedClasses();
        foreach ($this->types as $type) {
            foreach ($type->getReferencedClasses() as $referencedClass) {
                $classes[] = $referencedClass;
            }
        }
        return $classes;
    }
    /** @return array<int, Type> */
    public function getTypes() : array
    {
        return $this->types;
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $acceptsContext) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        $nakedSuperTypeOf = parent::isSuperTypeOf($type);
        if ($nakedSuperTypeOf->no()) {
            return $nakedSuperTypeOf;
        }
        if (!$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType) {
            return $nakedSuperTypeOf;
        }
        $ancestor = $type->getAncestorWithClassName($this->getClassName());
        if ($ancestor === null) {
            return $nakedSuperTypeOf;
        }
        if (!$ancestor instanceof self) {
            if ($acceptsContext) {
                return $nakedSuperTypeOf;
            }
            return $nakedSuperTypeOf->and(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
        }
        if (\count($this->types) !== \count($ancestor->types)) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return $nakedSuperTypeOf;
        }
        $typeList = $classReflection->typeMapToList($classReflection->getTemplateTypeMap());
        $results = [];
        foreach ($typeList as $i => $templateType) {
            if (!isset($ancestor->types[$i])) {
                continue;
            }
            if (!isset($this->types[$i])) {
                continue;
            }
            if ($templateType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                continue;
            }
            if (!$templateType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            $results[] = $templateType->isValidVariance($this->types[$i], $ancestor->types[$i]);
        }
        if (\count($results) === 0) {
            return $nakedSuperTypeOf;
        }
        return $nakedSuperTypeOf->and(...$results);
    }
    public function getClassReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($this->getClassName())) {
            return null;
        }
        return $this->classReflection = $broker->getClass($this->getClassName())->withTypes($this->types);
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        $reflection = parent::getProperty($propertyName, $scope);
        $ancestor = $this->getAncestorWithClassName($reflection->getDeclaringClass()->getName());
        if ($ancestor === null) {
            $classReflection = $reflection->getDeclaringClass();
        } else {
            $classReflection = $ancestor->getClassReflection();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedPropertyReflection($reflection, $classReflection->getActiveTemplateTypeMap());
    }
    public function getMethod(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $reflection = parent::getMethod($methodName, $scope);
        $ancestor = $this->getAncestorWithClassName($reflection->getDeclaringClass()->getName());
        if ($ancestor === null) {
            $classReflection = $reflection->getDeclaringClass();
        } else {
            $classReflection = $ancestor->getClassReflection();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedMethodReflection($reflection, $classReflection->getActiveTemplateTypeMap());
    }
    public function inferTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $receivedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if (!$receivedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $ancestor = $receivedType->getAncestorWithClassName($this->getClassName());
        if ($ancestor === null || !$ancestor instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $otherTypes = $ancestor->getTypes();
        $typeMap = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->getTypes() as $i => $type) {
            $other = $otherTypes[$i] ?? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            $typeMap = $typeMap->union($type->inferTemplateTypes($other));
        }
        return $typeMap;
    }
    public function getReferencedTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection !== null) {
            $typeList = $classReflection->typeMapToList($classReflection->getTemplateTypeMap());
        } else {
            $typeList = [];
        }
        $references = [];
        foreach ($this->types as $i => $type) {
            $variance = $positionVariance->compose(isset($typeList[$i]) && $typeList[$i] instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType ? $typeList[$i]->getVariance() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
            foreach ($type->getReferencedTemplateTypes($variance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $subtractedType = $this->getSubtractedType() !== null ? $cb($this->getSubtractedType()) : null;
        $typesChanged = \false;
        $types = [];
        foreach ($this->types as $type) {
            $newType = $cb($type);
            $types[] = $newType;
            if ($newType === $type) {
                continue;
            }
            $typesChanged = \true;
        }
        if ($subtractedType !== $this->getSubtractedType() || $typesChanged) {
            return new static($this->getClassName(), $types, $subtractedType);
        }
        return $this;
    }
    public function changeSubtractedType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($this->getClassName(), $this->types, $subtractedType);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['types'], $properties['subtractedType'] ?? null);
    }
}
