<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
class TypehintHelper
{
    private static function getTypeObjectFromTypehint(string $typeString, ?string $selfClass) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        switch (\strtolower($typeString)) {
            case 'int':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
            case 'bool':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
            case 'false':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
            case 'string':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
            case 'float':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType();
            case 'array':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
            case 'iterable':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
            case 'callable':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType();
            case 'void':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType();
            case 'object':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType();
            case 'mixed':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true);
            case 'self':
                return $selfClass !== null ? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($selfClass) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            case 'parent':
                $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
                if ($selfClass !== null && $broker->hasClass($selfClass)) {
                    $classReflection = $broker->getClass($selfClass);
                    if ($classReflection->getParentClass() !== \false) {
                        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($classReflection->getParentClass()->getName());
                    }
                }
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NonexistentParentClassType();
            case 'static':
                return $selfClass !== null ? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType($selfClass) : new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
            case 'null':
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
            default:
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($typeString);
        }
    }
    public static function decideTypeFromReflection(?\ReflectionType $reflectionType, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType = null, ?string $selfClass = null, bool $isVariadic = \false) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($reflectionType === null) {
            if ($isVariadic && $phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                $phpDocType = $phpDocType->getItemType();
            }
            return $phpDocType ?? new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        }
        if ($reflectionType instanceof \ReflectionUnionType) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\ReflectionType $type) use($selfClass) : Type {
                return self::decideTypeFromReflection($type, null, $selfClass, \false);
            }, $reflectionType->getTypes()));
            return self::decideType($type, $phpDocType);
        }
        if (!$reflectionType instanceof \ReflectionNamedType) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Unexpected type: %s', \get_class($reflectionType)));
        }
        $reflectionTypeString = $reflectionType->getName();
        if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\object')) {
            $reflectionTypeString = 'object';
        }
        if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\mixed')) {
            $reflectionTypeString = 'mixed';
        }
        if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\false')) {
            $reflectionTypeString = 'false';
        }
        if (\TenantCloud\BetterReflection\Relocated\Nette\Utils\Strings::endsWith(\strtolower($reflectionTypeString), '\\null')) {
            $reflectionTypeString = 'null';
        }
        $type = self::getTypeObjectFromTypehint($reflectionTypeString, $selfClass);
        if ($reflectionType->allowsNull()) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull($type);
        } elseif ($phpDocType !== null) {
            $phpDocType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::removeNull($phpDocType);
        }
        return self::decideType($type, $phpDocType);
    }
    public static function decideType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $phpDocType = null) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($phpDocType !== null && !$phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType) {
                if ($phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && $phpDocType->isExplicit()) {
                    return $phpDocType;
                }
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType();
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$type->isExplicitMixed() && $phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType) {
                return $phpDocType;
            }
            if (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::removeNull($type) instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType) {
                if ($phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                    $innerTypes = [];
                    foreach ($phpDocType->getTypes() as $innerType) {
                        if ($innerType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                            $innerTypes[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType($innerType->getKeyType(), $innerType->getItemType());
                        } else {
                            $innerTypes[] = $innerType;
                        }
                    }
                    $phpDocType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType($innerTypes);
                } elseif ($phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                    $phpDocType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType($phpDocType->getKeyType(), $phpDocType->getItemType());
                }
            }
            if ((!$phpDocType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$type->isExplicitMixed()) && $type->isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($phpDocType))->yes()) {
                $resultType = $phpDocType;
            } else {
                $resultType = $type;
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                $addToUnionTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$innerType->isSuperTypeOf($resultType)->no()) {
                        continue;
                    }
                    $addToUnionTypes[] = $innerType;
                }
                if (\count($addToUnionTypes) > 0) {
                    $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($resultType, ...$addToUnionTypes);
                } else {
                    $type = $resultType;
                }
            } elseif (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::containsNull($type)) {
                $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull($resultType);
            } else {
                $type = $resultType;
            }
        }
        return $type;
    }
}
