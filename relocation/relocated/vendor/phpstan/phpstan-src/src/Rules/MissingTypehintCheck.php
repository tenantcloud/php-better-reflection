<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
class MissingTypehintCheck
{
    public const TURN_OFF_MISSING_ITERABLE_VALUE_TYPE_TIP = 'See: https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type';
    public const TURN_OFF_NON_GENERIC_CHECK_TIP = 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.';
    private const ITERABLE_GENERIC_CLASS_NAMES = [\Traversable::class, \Iterator::class, \IteratorAggregate::class, \Generator::class];
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private bool $checkMissingIterableValueType;
    private bool $checkGenericClassInNonGenericObjectType;
    private bool $checkMissingCallableSignature;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkMissingIterableValueType, bool $checkGenericClassInNonGenericObjectType, bool $checkMissingCallableSignature)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkMissingIterableValueType = $checkMissingIterableValueType;
        $this->checkGenericClassInNonGenericObjectType = $checkGenericClassInNonGenericObjectType;
        $this->checkMissingCallableSignature = $checkMissingCallableSignature;
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Type[]
     */
    public function getIterableTypesWithMissingValueTypehint(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if (!$this->checkMissingIterableValueType) {
            return [];
        }
        $iterablesWithMissingValueTypehint = [];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use(&$iterablesWithMissingValueTypehint) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                return $type;
            }
            if ($type->isIterable()->yes()) {
                $iterableValue = $type->getIterableValueType();
                if ($iterableValue instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$iterableValue->isExplicitMixed()) {
                    if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName && !\in_array($type->getClassName(), self::ITERABLE_GENERIC_CLASS_NAMES, \true) && $this->reflectionProvider->hasClass($type->getClassName())) {
                        $classReflection = $this->reflectionProvider->getClass($type->getClassName());
                        if ($classReflection->isGeneric()) {
                            return $type;
                        }
                    }
                    $iterablesWithMissingValueTypehint[] = $type;
                }
                return $type;
            }
            return $traverse($type);
        });
        return $iterablesWithMissingValueTypehint;
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return array<int, array{string, string[]}>
     */
    public function getNonGenericObjectTypesWithGenericClass(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if (!$this->checkGenericClassInNonGenericObjectType) {
            return [];
        }
        $objectTypes = [];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use(&$objectTypes) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
                $traverse($type);
                return $type;
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                return $type;
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType) {
                $classReflection = $type->getClassReflection();
                if ($classReflection === null) {
                    return $type;
                }
                if (\in_array($classReflection->getName(), self::ITERABLE_GENERIC_CLASS_NAMES, \true)) {
                    // checked by getIterableTypesWithMissingValueTypehint() already
                    return $type;
                }
                if ($classReflection->isTrait()) {
                    return $type;
                }
                if (!$classReflection->isGeneric()) {
                    return $type;
                }
                $resolvedType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($type);
                if (!$resolvedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType) {
                    throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
                }
                $objectTypes[] = [\sprintf('%s %s', $classReflection->isInterface() ? 'interface' : 'class', $classReflection->getDisplayName(\false)), \array_keys($classReflection->getTemplateTypeMap()->getTypes())];
                return $type;
            }
            $traverse($type);
            return $type;
        });
        return $objectTypes;
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @return \PHPStan\Type\Type[]
     */
    public function getCallablesWithMissingSignature(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : array
    {
        if (!$this->checkMissingCallableSignature) {
            return [];
        }
        $result = [];
        \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use(&$result) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CallableType && $type->isCommonCallable() || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType && $type->getClassName() === \Closure::class) {
                $result[] = $type;
            }
            return $traverse($type);
        });
        return $result;
    }
}
