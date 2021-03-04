<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc;

use TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ResourceType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
class TypeNodeResolver
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider $extensionRegistryProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider $extensionRegistryProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->extensionRegistryProvider = $extensionRegistryProvider;
        $this->container = $container;
    }
    public function resolve(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        foreach ($this->extensionRegistryProvider->getRegistry()->getExtensions() as $extension) {
            $type = $extension->resolve($typeNode, $nameScope);
            if ($type !== null) {
                return $type;
            }
        }
        if ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return $this->resolveIdentifierTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode) {
            return $this->resolveThisTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode) {
            return $this->resolveNullableTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return $this->resolveUnionTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode) {
            return $this->resolveIntersectionTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
            return $this->resolveArrayTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode) {
            return $this->resolveGenericTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode) {
            return $this->resolveCallableTypeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode) {
            return $this->resolveArrayShapeNode($typeNode, $nameScope);
        } elseif ($typeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode) {
            return $this->resolveConstTypeNode($typeNode, $nameScope);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    private function resolveIdentifierTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        switch (\strtolower($typeNode->name)) {
            case 'int':
            case 'integer':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
            case 'positive-int':
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(1, null);
            case 'negative-int':
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType::fromInterval(null, -1);
            case 'string':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
            case 'class-string':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClassStringType();
            case 'callable-string':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType()]);
            case 'array-key':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]);
            case 'scalar':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType()]);
            case 'number':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType()]);
            case 'numeric':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType()])]);
            case 'numeric-string':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryNumericStringType()]);
            case 'bool':
            case 'boolean':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
            case 'true':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\true);
            case 'false':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
            case 'null':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            case 'float':
            case 'double':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType();
            case 'array':
            case 'associative-array':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
            case 'non-empty-array':
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType());
            case 'iterable':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
            case 'callable':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType();
            case 'resource':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ResourceType();
            case 'mixed':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true);
            case 'void':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType();
            case 'object':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType();
            case 'never':
            case 'never-return':
            case 'never-returns':
            case 'no-return':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType(\true);
            case 'list':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
            case 'non-empty-list':
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType()), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType());
        }
        if ($nameScope->getClassName() !== null) {
            switch (\strtolower($typeNode->name)) {
                case 'self':
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($nameScope->getClassName());
                case 'static':
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType($nameScope->getClassName());
                case 'parent':
                    if ($this->getReflectionProvider()->hasClass($nameScope->getClassName())) {
                        $classReflection = $this->getReflectionProvider()->getClass($nameScope->getClassName());
                        if ($classReflection->getParentClass() !== \false) {
                            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($classReflection->getParentClass()->getName());
                        }
                    }
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType();
            }
        }
        $templateType = $nameScope->resolveTemplateTypeName($typeNode->name);
        if ($templateType !== null) {
            return $templateType;
        }
        $stringName = $nameScope->resolveStringName($typeNode->name);
        if (\strpos($stringName, '-') !== \false && \strpos($stringName, 'OCI-') !== 0) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($stringName);
    }
    private function resolveThisTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ThisTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $className = $nameScope->getClassName();
        if ($className !== null) {
            if ($this->getReflectionProvider()->hasClass($className)) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType($this->getReflectionProvider()->getClass($className));
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    private function resolveNullableTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\NullableTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull($this->resolve($typeNode->type, $nameScope));
    }
    private function resolveUnionTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $iterableTypeNodes = [];
        $otherTypeNodes = [];
        foreach ($typeNode->types as $innerTypeNode) {
            if ($innerTypeNode instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode) {
                $iterableTypeNodes[] = $innerTypeNode->type;
            } else {
                $otherTypeNodes[] = $innerTypeNode;
            }
        }
        $otherTypeTypes = $this->resolveMultiple($otherTypeNodes, $nameScope);
        if (\count($iterableTypeNodes) > 0) {
            $arrayTypeTypes = $this->resolveMultiple($iterableTypeNodes, $nameScope);
            $arrayTypeType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$arrayTypeTypes);
            $addArray = \true;
            foreach ($otherTypeTypes as &$type) {
                if (!$type->isIterable()->yes() || !$type->getIterableValueType()->isSuperTypeOf($arrayTypeType)->yes()) {
                    continue;
                }
                if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType) {
                    $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType([$type, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $arrayTypeType)]);
                } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                    $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $arrayTypeType);
                } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType) {
                    $type = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $arrayTypeType);
                } else {
                    continue;
                }
                $addArray = \false;
            }
            if ($addArray) {
                $otherTypeTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $arrayTypeType);
            }
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$otherTypeTypes);
    }
    private function resolveIntersectionTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IntersectionTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $types = $this->resolveMultiple($typeNode->types, $nameScope);
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(...$types);
    }
    private function resolveArrayTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $itemType = $this->resolve($typeNode->type, $nameScope);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), $itemType);
    }
    private function resolveGenericTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $mainTypeName = \strtolower($typeNode->type->name);
        $genericTypes = $this->resolveMultiple($typeNode->genericTypes, $nameScope);
        if ($mainTypeName === 'array' || $mainTypeName === 'non-empty-array') {
            if (\count($genericTypes) === 1) {
                // array<ValueType>
                $arrayType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), $genericTypes[0]);
            } elseif (\count($genericTypes) === 2) {
                // array<KeyType, ValueType>
                $arrayType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType($genericTypes[0], $genericTypes[1]);
            } else {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            }
            if ($mainTypeName === 'non-empty-array') {
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($arrayType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType());
            }
            return $arrayType;
        } elseif ($mainTypeName === 'list' || $mainTypeName === 'non-empty-list') {
            if (\count($genericTypes) === 1) {
                // list<ValueType>
                $listType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), $genericTypes[0]);
                if ($mainTypeName === 'non-empty-list') {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($listType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\NonEmptyArrayType());
                }
                return $listType;
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        } elseif ($mainTypeName === 'iterable') {
            if (\count($genericTypes) === 1) {
                // iterable<ValueType>
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), $genericTypes[0]);
            }
            if (\count($genericTypes) === 2) {
                // iterable<KeyType, ValueType>
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType($genericTypes[0], $genericTypes[1]);
            }
        } elseif ($mainTypeName === 'class-string') {
            if (\count($genericTypes) === 1) {
                $genericType = $genericTypes[0];
                if ((new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType())->isSuperTypeOf($genericType)->yes() || $genericType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericClassStringType($genericType);
                }
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
        }
        $mainType = $this->resolveIdentifierTypeNode($typeNode->type, $nameScope);
        if ($mainType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
            if (!$this->getReflectionProvider()->hasClass($mainType->getClassName())) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
            }
            $classReflection = $this->getReflectionProvider()->getClass($mainType->getClassName());
            if ($classReflection->isGeneric()) {
                if (\in_array($mainType->getClassName(), [\Traversable::class, \IteratorAggregate::class, \Iterator::class], \true)) {
                    if (\count($genericTypes) === 1) {
                        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), $genericTypes[0]]);
                    }
                    if (\count($genericTypes) === 2) {
                        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$genericTypes[0], $genericTypes[1]]);
                    }
                }
                if ($mainType->getClassName() === \Generator::class) {
                    if (\count($genericTypes) === 1) {
                        $mixed = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true);
                        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$mixed, $genericTypes[0], $mixed, $mixed]);
                    }
                    if (\count($genericTypes) === 2) {
                        $mixed = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true);
                        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), [$genericTypes[0], $genericTypes[1], $mixed, $mixed]);
                    }
                }
                if (!$mainType->isIterable()->yes()) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
                }
                if (\count($genericTypes) !== 1 || $classReflection->getTemplateTypeMap()->count() === 1) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
                }
            }
        }
        if ($mainType->isIterable()->yes()) {
            if (\count($genericTypes) === 1) {
                // Foo<ValueType>
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($mainType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true), $genericTypes[0]));
            }
            if (\count($genericTypes) === 2) {
                // Foo<KeyType, ValueType>
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect($mainType, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType($genericTypes[0], $genericTypes[1]));
            }
        }
        if ($mainType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($mainType->getClassName(), $genericTypes);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    private function resolveCallableTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\CallableTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $mainType = $this->resolve($typeNode->identifier, $nameScope);
        $isVariadic = \false;
        $parameters = \array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\CallableTypeParameterNode $parameterNode) use($nameScope, &$isVariadic) : NativeParameterReflection {
            $isVariadic = $isVariadic || $parameterNode->isVariadic;
            $parameterName = $parameterNode->parameterName;
            if (\strpos($parameterName, '$') === 0) {
                $parameterName = \substr($parameterName, 1);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection($parameterName, $parameterNode->isOptional || $parameterNode->isVariadic, $this->resolve($parameterNode->type, $nameScope), $parameterNode->isReference ? \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference::createNo(), $parameterNode->isVariadic, null);
        }, $typeNode->parameters);
        $returnType = $this->resolve($typeNode->returnType, $nameScope);
        if ($mainType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType($parameters, $returnType, $isVariadic);
        } elseif ($mainType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType && $mainType->getClassName() === \Closure::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType($parameters, $returnType, $isVariadic);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    private function resolveArrayShapeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ArrayShapeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $builder = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        foreach ($typeNode->items as $itemNode) {
            $offsetType = null;
            if ($itemNode->keyName instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
                $offsetType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantIntegerType((int) $itemNode->keyName->value);
            } elseif ($itemNode->keyName instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
                $offsetType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType($itemNode->keyName->name);
            } elseif ($itemNode->keyName instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
                $offsetType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType($itemNode->keyName->value);
            } elseif ($itemNode->keyName !== null) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('Unsupported key node type: ' . \get_class($itemNode->keyName));
            }
            $builder->setOffsetValueType($offsetType, $this->resolve($itemNode->valueType, $nameScope), $itemNode->optional);
        }
        return $builder->getArray();
    }
    private function resolveConstTypeNode(\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\Type\ConstTypeNode $typeNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $constExpr = $typeNode->constExpr;
        if ($constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            // we prefer array shapes
        }
        if ($constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode || $constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode || $constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            // we prefer IdentifierTypeNode
        }
        if ($constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstFetchNode) {
            if ($constExpr->className === '') {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                // global constant should get parsed as class name in IdentifierTypeNode
            }
            if ($nameScope->getClassName() !== null) {
                switch (\strtolower($constExpr->className)) {
                    case 'static':
                    case 'self':
                        $className = $nameScope->getClassName();
                        break;
                    case 'parent':
                        if ($this->getReflectionProvider()->hasClass($nameScope->getClassName())) {
                            $classReflection = $this->getReflectionProvider()->getClass($nameScope->getClassName());
                            if ($classReflection->getParentClass() === \false) {
                                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
                            }
                            $className = $classReflection->getParentClass()->getName();
                        }
                }
            }
            if (!isset($className)) {
                $className = $nameScope->resolveStringName($constExpr->className);
            }
            if (!$this->getReflectionProvider()->hasClass($className)) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            }
            $classReflection = $this->getReflectionProvider()->getClass($className);
            $constantName = $constExpr->name;
            if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::endsWith($constantName, '*')) {
                $constantNameStartsWith = \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::substring($constantName, 0, \TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::length($constantName) - 1);
                $constantTypes = [];
                foreach ($classReflection->getNativeReflection()->getConstants() as $classConstantName => $constantValue) {
                    if (!\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::startsWith($classConstantName, $constantNameStartsWith)) {
                        continue;
                    }
                    $constantTypes[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constantValue);
                }
                if (\count($constantTypes) === 0) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
                }
                return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$constantTypes);
            }
            if (!$classReflection->hasConstant($constantName)) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            }
            return $classReflection->getConstant($constantName)->getValueType();
        }
        if ($constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $constExpr->value);
        }
        if ($constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $constExpr->value);
        }
        if ($constExpr instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($constExpr->value);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    /**
     * @param TypeNode[] $typeNodes
     * @param NameScope $nameScope
     * @return Type[]
     */
    public function resolveMultiple(array $typeNodes, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NameScope $nameScope) : array
    {
        $types = [];
        foreach ($typeNodes as $typeNode) {
            $types[] = $this->resolve($typeNode, $nameScope);
        }
        return $types;
    }
    private function getReflectionProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        return $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider::class);
    }
}
