<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
class ParametersAcceptorSelector
{
    /**
     * @template T of ParametersAcceptor
     * @param T[] $parametersAcceptors
     * @return T
     */
    public static function selectSingle(array $parametersAcceptors) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
    {
        if (\count($parametersAcceptors) !== 1) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return $parametersAcceptors[0];
    }
    /**
     * @param Scope $scope
     * @param \PhpParser\Node\Arg[] $args
     * @param ParametersAcceptor[] $parametersAcceptors
     * @return ParametersAcceptor
     */
    public static function selectFromArgs(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, array $args, array $parametersAcceptors) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
    {
        $types = [];
        $unpack = \false;
        foreach ($args as $arg) {
            $type = $scope->getType($arg->value);
            if ($arg->unpack) {
                $unpack = \true;
                $types[] = $type->getIterableValueType();
            } else {
                $types[] = $type;
            }
        }
        return self::selectFromTypes($types, $parametersAcceptors, $unpack);
    }
    /**
     * @param \PHPStan\Type\Type[] $types
     * @param ParametersAcceptor[] $parametersAcceptors
     * @param bool $unpack
     * @return ParametersAcceptor
     */
    public static function selectFromTypes(array $types, array $parametersAcceptors, bool $unpack) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
    {
        if (\count($parametersAcceptors) === 1) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GenericParametersAcceptorResolver::resolve($types, $parametersAcceptors[0]);
        }
        if (\count($parametersAcceptors) === 0) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('getVariants() must return at least one variant.');
        }
        $typesCount = \count($types);
        $acceptableAcceptors = [];
        foreach ($parametersAcceptors as $parametersAcceptor) {
            if ($unpack) {
                $acceptableAcceptors[] = $parametersAcceptor;
                continue;
            }
            $functionParametersMinCount = 0;
            $functionParametersMaxCount = 0;
            foreach ($parametersAcceptor->getParameters() as $parameter) {
                if (!$parameter->isOptional()) {
                    $functionParametersMinCount++;
                }
                $functionParametersMaxCount++;
            }
            if ($typesCount < $functionParametersMinCount) {
                continue;
            }
            if (!$parametersAcceptor->isVariadic() && $typesCount > $functionParametersMaxCount) {
                continue;
            }
            $acceptableAcceptors[] = $parametersAcceptor;
        }
        if (\count($acceptableAcceptors) === 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GenericParametersAcceptorResolver::resolve($types, self::combineAcceptors($parametersAcceptors));
        }
        if (\count($acceptableAcceptors) === 1) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GenericParametersAcceptorResolver::resolve($types, $acceptableAcceptors[0]);
        }
        $winningAcceptors = [];
        $winningCertainty = null;
        foreach ($acceptableAcceptors as $acceptableAcceptor) {
            $isSuperType = \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
            $acceptableAcceptor = \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GenericParametersAcceptorResolver::resolve($types, $acceptableAcceptor);
            foreach ($acceptableAcceptor->getParameters() as $i => $parameter) {
                if (!isset($types[$i])) {
                    if (!$unpack || \count($types) <= 0) {
                        break;
                    }
                    $type = $types[\count($types) - 1];
                } else {
                    $type = $types[$i];
                }
                if ($parameter->getType() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                    $isSuperType = $isSuperType->and(\TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe());
                } else {
                    $isSuperType = $isSuperType->and($parameter->getType()->isSuperTypeOf($type));
                }
            }
            if ($isSuperType->no()) {
                continue;
            }
            if ($winningCertainty === null) {
                $winningAcceptors[] = $acceptableAcceptor;
                $winningCertainty = $isSuperType;
            } else {
                $comparison = $winningCertainty->compareTo($isSuperType);
                if ($comparison === $isSuperType) {
                    $winningAcceptors = [$acceptableAcceptor];
                    $winningCertainty = $isSuperType;
                } elseif ($comparison === null) {
                    $winningAcceptors[] = $acceptableAcceptor;
                }
            }
        }
        if (\count($winningAcceptors) === 0) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GenericParametersAcceptorResolver::resolve($types, self::combineAcceptors($acceptableAcceptors));
        }
        return self::combineAcceptors($winningAcceptors);
    }
    /**
     * @param ParametersAcceptor[] $acceptors
     * @return ParametersAcceptor
     */
    public static function combineAcceptors(array $acceptors) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor
    {
        if (\count($acceptors) === 0) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException('getVariants() must return at least one variant.');
        }
        if (\count($acceptors) === 1) {
            return $acceptors[0];
        }
        $minimumNumberOfParameters = null;
        foreach ($acceptors as $acceptor) {
            $acceptorParametersMinCount = 0;
            foreach ($acceptor->getParameters() as $parameter) {
                if ($parameter->isOptional()) {
                    continue;
                }
                $acceptorParametersMinCount++;
            }
            if ($minimumNumberOfParameters !== null && $minimumNumberOfParameters <= $acceptorParametersMinCount) {
                continue;
            }
            $minimumNumberOfParameters = $acceptorParametersMinCount;
        }
        $parameters = [];
        $isVariadic = \false;
        $returnType = null;
        foreach ($acceptors as $acceptor) {
            if ($returnType === null) {
                $returnType = $acceptor->getReturnType();
            } else {
                $returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($returnType, $acceptor->getReturnType());
            }
            $isVariadic = $isVariadic || $acceptor->isVariadic();
            foreach ($acceptor->getParameters() as $i => $parameter) {
                if (!isset($parameters[$i])) {
                    $parameters[$i] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection($parameter->getName(), $i + 1 > $minimumNumberOfParameters, $parameter->getType(), $parameter->passedByReference(), $parameter->isVariadic(), $parameter->getDefaultValue());
                    continue;
                }
                $isVariadic = $parameters[$i]->isVariadic() || $parameter->isVariadic();
                $defaultValueLeft = $parameters[$i]->getDefaultValue();
                $defaultValueRight = $parameter->getDefaultValue();
                if ($defaultValueLeft !== null && $defaultValueRight !== null) {
                    $defaultValue = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($defaultValueLeft, $defaultValueRight);
                } else {
                    $defaultValue = null;
                }
                $parameters[$i] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Native\NativeParameterReflection($parameters[$i]->getName() !== $parameter->getName() ? \sprintf('%s|%s', $parameters[$i]->getName(), $parameter->getName()) : $parameter->getName(), $i + 1 > $minimumNumberOfParameters, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union($parameters[$i]->getType(), $parameter->getType()), $parameters[$i]->passedByReference()->combine($parameter->passedByReference()), $isVariadic, $defaultValue);
                if ($isVariadic) {
                    $parameters = \array_slice($parameters, 0, $i + 1);
                    break;
                }
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, $parameters, $isVariadic, $returnType);
    }
}
