<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
class ParserNodeTypeToPHPStanType
{
    /**
     * @param \PhpParser\Node\Name|\PhpParser\Node\Identifier|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $type
     * @param string|null $className
     * @return Type
     */
    public static function resolve($type, ?string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($type === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
        } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $typeClassName = (string) $type;
            $lowercasedClassName = \strtolower($typeClassName);
            if ($className !== null && \in_array($lowercasedClassName, ['self', 'static'], \true)) {
                $typeClassName = $className;
            } elseif ($lowercasedClassName === 'parent') {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('parent type is not supported here');
            }
            if ($lowercasedClassName === 'static') {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType($typeClassName);
            }
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($typeClassName);
        } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\NullableType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::addNull(self::resolve($type->type, $className));
        } elseif ($type instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\UnionType) {
            $types = [];
            foreach ($type->types as $unionTypeType) {
                $types[] = self::resolve($unionTypeType, $className);
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$types);
        }
        $type = $type->name;
        if ($type === 'string') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
        } elseif ($type === 'int') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType();
        } elseif ($type === 'bool') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType();
        } elseif ($type === 'float') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FloatType();
        } elseif ($type === 'callable') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType();
        } elseif ($type === 'array') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        } elseif ($type === 'iterable') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IterableType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
        } elseif ($type === 'void') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType();
        } elseif ($type === 'object') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type === 'false') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType(\false);
        } elseif ($type === 'null') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType();
        } elseif ($type === 'mixed') {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true);
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType();
    }
}
