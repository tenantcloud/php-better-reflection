<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Comparison;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Arg;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
class ImpossibleCheckTypeHelper
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier;
    /** @var string[] */
    private array $universalObjectCratesClasses;
    private bool $treatPhpDocTypesAsCertain;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\Analyser\TypeSpecifier $typeSpecifier
     * @param string[] $universalObjectCratesClasses
     * @param bool $treatPhpDocTypesAsCertain
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier, array $universalObjectCratesClasses, bool $treatPhpDocTypesAsCertain)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->typeSpecifier = $typeSpecifier;
        $this->universalObjectCratesClasses = $universalObjectCratesClasses;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function findSpecifiedType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $node) : ?bool
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall && \count($node->args) > 0) {
            if ($node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
                $functionName = \strtolower((string) $node->name);
                if ($functionName === 'assert') {
                    $assertValue = $scope->getType($node->args[0]->value)->toBoolean();
                    if (!$assertValue instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantBooleanType) {
                        return null;
                    }
                    return $assertValue->getValue();
                }
                if (\in_array($functionName, ['class_exists', 'interface_exists', 'trait_exists'], \true)) {
                    return null;
                }
                if ($functionName === 'count') {
                    return null;
                } elseif ($functionName === 'defined') {
                    return null;
                } elseif ($functionName === 'in_array' && \count($node->args) >= 3) {
                    $haystackType = $scope->getType($node->args[1]->value);
                    if ($haystackType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
                        return null;
                    }
                    if (!$haystackType->isArray()->yes()) {
                        return null;
                    }
                    if (!$haystackType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType || \count($haystackType->getValueTypes()) > 0) {
                        $needleType = $scope->getType($node->args[0]->value);
                        $haystackArrayTypes = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getArrays($haystackType);
                        if (\count($haystackArrayTypes) === 1 && $haystackArrayTypes[0]->getIterableValueType() instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
                            return null;
                        }
                        $valueType = $haystackType->getIterableValueType();
                        $isNeedleSupertype = $needleType->isSuperTypeOf($valueType);
                        if ($isNeedleSupertype->maybe() || $isNeedleSupertype->yes()) {
                            foreach ($haystackArrayTypes as $haystackArrayType) {
                                foreach (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantScalars($haystackArrayType->getIterableValueType()) as $constantScalarType) {
                                    if ($needleType->isSuperTypeOf($constantScalarType)->yes()) {
                                        continue 2;
                                    }
                                }
                                return null;
                            }
                        }
                        if ($isNeedleSupertype->yes()) {
                            $hasConstantNeedleTypes = \count(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantScalars($needleType)) > 0;
                            $hasConstantHaystackTypes = \count(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantScalars($valueType)) > 0;
                            if (!$hasConstantNeedleTypes && !$hasConstantHaystackTypes || $hasConstantNeedleTypes !== $hasConstantHaystackTypes) {
                                return null;
                            }
                        }
                    }
                } elseif ($functionName === 'method_exists' && \count($node->args) >= 2) {
                    $objectType = $scope->getType($node->args[0]->value);
                    $methodType = $scope->getType($node->args[1]->value);
                    if ($objectType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType && !$this->reflectionProvider->hasClass($objectType->getValue())) {
                        return \false;
                    }
                    if ($methodType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                        if ($objectType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType) {
                            $objectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($objectType->getValue());
                        }
                        if ($objectType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
                            if ($objectType->hasMethod($methodType->getValue())->yes()) {
                                return \true;
                            }
                            if ($objectType->hasMethod($methodType->getValue())->no()) {
                                return \false;
                            }
                        }
                    }
                }
            }
        }
        $specifiedTypes = $this->typeSpecifier->specifyTypesInCondition($scope, $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
        $sureTypes = $specifiedTypes->getSureTypes();
        $sureNotTypes = $specifiedTypes->getSureNotTypes();
        $isSpecified = static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) use($scope, $node) : bool {
            return ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall) && $scope->isSpecified($expr);
        };
        if (\count($sureTypes) === 1 && \count($sureNotTypes) === 0) {
            $sureType = \reset($sureTypes);
            if ($isSpecified($sureType[0])) {
                return null;
            }
            if ($this->treatPhpDocTypesAsCertain) {
                $argumentType = $scope->getType($sureType[0]);
            } else {
                $argumentType = $scope->getNativeType($sureType[0]);
            }
            /** @var \PHPStan\Type\Type $resultType */
            $resultType = $sureType[1];
            $isSuperType = $resultType->isSuperTypeOf($argumentType);
            if ($isSuperType->yes()) {
                return \true;
            } elseif ($isSuperType->no()) {
                return \false;
            }
            return null;
        } elseif (\count($sureNotTypes) === 1 && \count($sureTypes) === 0) {
            $sureNotType = \reset($sureNotTypes);
            if ($isSpecified($sureNotType[0])) {
                return null;
            }
            if ($this->treatPhpDocTypesAsCertain) {
                $argumentType = $scope->getType($sureNotType[0]);
            } else {
                $argumentType = $scope->getNativeType($sureNotType[0]);
            }
            /** @var \PHPStan\Type\Type $resultType */
            $resultType = $sureNotType[1];
            $isSuperType = $resultType->isSuperTypeOf($argumentType);
            if ($isSuperType->yes()) {
                return \false;
            } elseif ($isSuperType->no()) {
                return \true;
            }
            return null;
        }
        if (\count($sureTypes) > 0) {
            foreach ($sureTypes as $sureType) {
                if ($isSpecified($sureType[0])) {
                    return null;
                }
            }
            $types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_column($sureTypes, 1));
            if ($types instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
                return \false;
            }
        }
        if (\count($sureNotTypes) > 0) {
            foreach ($sureNotTypes as $sureNotType) {
                if ($isSpecified($sureNotType[0])) {
                    return null;
                }
            }
            $types = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...\array_column($sureNotTypes, 1));
            if ($types instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
                return \true;
            }
        }
        return null;
    }
    /**
     * @param Scope $scope
     * @param \PhpParser\Node\Arg[] $args
     * @return string
     */
    public function getArgumentsDescription(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, array $args) : string
    {
        if (\count($args) === 0) {
            return '';
        }
        $descriptions = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Arg $arg) use($scope) : string {
            return $scope->getType($arg->value)->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::value());
        }, $args);
        if (\count($descriptions) < 3) {
            return \sprintf(' with %s', \implode(' and ', $descriptions));
        }
        $lastDescription = \array_pop($descriptions);
        return \sprintf(' with arguments %s and %s', \implode(', ', $descriptions), $lastDescription);
    }
    public function doNotTreatPhpDocTypesAsCertain() : self
    {
        if (!$this->treatPhpDocTypesAsCertain) {
            return $this;
        }
        return new self($this->reflectionProvider, $this->typeSpecifier, $this->universalObjectCratesClasses, \false);
    }
}
