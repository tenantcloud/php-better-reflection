<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
class TypeUtils
{
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ArrayType[]
     */
    public static function getArrays(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            return $type->getAllArrays();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
            return [$type];
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                    return [];
                }
                foreach (self::getArrays($innerType) as $innerInnerType) {
                    $matchingTypes[] = $innerInnerType;
                }
            }
            return $matchingTypes;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType) {
                    continue;
                }
                foreach (self::getArrays($innerType) as $innerInnerType) {
                    $matchingTypes[] = $innerInnerType;
                }
            }
            return $matchingTypes;
        }
        return [];
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Constant\ConstantArrayType[]
     */
    public static function getConstantArrays(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            return $type->getAllArrays();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                    return [];
                }
                foreach (self::getConstantArrays($innerType) as $innerInnerType) {
                    $matchingTypes[] = $innerInnerType;
                }
            }
            return $matchingTypes;
        }
        return [];
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Constant\ConstantStringType[]
     */
    public static function getConstantStrings(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        return self::map(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType::class, $type, \false);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ConstantType[]
     */
    public static function getConstantTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        return self::map(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType::class, $type, \false);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ConstantType[]
     */
    public static function getAnyConstantTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        return self::map(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType::class, $type, \false, \false);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\ArrayType[]
     */
    public static function getAnyArrays(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        return self::map(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType::class, $type, \true, \false);
    }
    public static function generalizeType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType) {
                return $type->generalize();
            }
            return $traverse($type);
        });
    }
    /**
     * @param Type $type
     * @return string[]
     */
    public static function getDirectClassNames(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
            return [$type->getClassName()];
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            $classNames = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
                    continue;
                }
                $classNames[] = $innerType->getClassName();
            }
            return $classNames;
        }
        return [];
    }
    /**
     * @param Type $type
     * @return \PHPStan\Type\ConstantScalarType[]
     */
    public static function getConstantScalars(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        return self::map(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantScalarType::class, $type, \false);
    }
    /**
     * @internal
     * @param Type $type
     * @return ConstantArrayType[]
     */
    public static function getOldConstantArrays(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        return self::map(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType::class, $type, \false);
    }
    /**
     * @param string $typeClass
     * @param Type $type
     * @param bool $inspectIntersections
     * @param bool $stopOnUnmatched
     * @return mixed[]
     */
    private static function map(string $typeClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $inspectIntersections, bool $stopOnUnmatched = \true) : array
    {
        if ($type instanceof $typeClass) {
            return [$type];
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof $typeClass) {
                    if ($stopOnUnmatched) {
                        return [];
                    }
                    continue;
                }
                $matchingTypes[] = $innerType;
            }
            return $matchingTypes;
        }
        if ($inspectIntersections && $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            $matchingTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof $typeClass) {
                    if ($stopOnUnmatched) {
                        return [];
                    }
                    continue;
                }
                $matchingTypes[] = $innerType;
            }
            return $matchingTypes;
        }
        return [];
    }
    public static function toBenevolentUnion(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType) {
            return $type;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType($type->getTypes());
        }
        return $type;
    }
    /**
     * @param Type $type
     * @return Type[]
     */
    public static function flattenTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
            return $type->getAllArrays();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            $types = [];
            foreach ($type->getTypes() as $innerType) {
                if ($innerType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                    foreach ($innerType->getAllArrays() as $array) {
                        $types[] = $array;
                    }
                    continue;
                }
                $types[] = $innerType;
            }
            return $types;
        }
        return [$type];
    }
    public static function findThisType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ThisType) {
            return $type;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            foreach ($type->getTypes() as $innerType) {
                $thisType = self::findThisType($innerType);
                if ($thisType !== null) {
                    return $thisType;
                }
            }
        }
        return null;
    }
    /**
     * @param Type $type
     * @return HasPropertyType[]
     */
    public static function getHasPropertyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\HasPropertyType) {
            return [$type];
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntersectionType) {
            $hasPropertyTypes = [[]];
            foreach ($type->getTypes() as $innerType) {
                $hasPropertyTypes[] = self::getHasPropertyTypes($innerType);
            }
            return \array_merge(...$hasPropertyTypes);
        }
        return [];
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Accessory\AccessoryType[]
     */
    public static function getAccessoryTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        return self::map(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Accessory\AccessoryType::class, $type, \true, \false);
    }
    public static function containsCallable(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if ($type->isCallable()->yes()) {
            return \true;
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $innerType) {
                if ($innerType->isCallable()->yes()) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
