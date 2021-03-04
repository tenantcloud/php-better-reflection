<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StrictMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
class RuleLevelHelper
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private bool $checkNullables;
    private bool $checkThisOnly;
    private bool $checkUnionTypes;
    private bool $checkExplicitMixed;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, bool $checkNullables, bool $checkThisOnly, bool $checkUnionTypes, bool $checkExplicitMixed = \false)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->checkNullables = $checkNullables;
        $this->checkThisOnly = $checkThisOnly;
        $this->checkUnionTypes = $checkUnionTypes;
        $this->checkExplicitMixed = $checkExplicitMixed;
    }
    public function isThis(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expression) : bool
    {
        return $expression instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable && $expression->name === 'this';
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptedType, bool $strictTypes) : bool
    {
        if ($this->checkExplicitMixed && $acceptedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && $acceptedType->isExplicitMixed()) {
            $acceptedType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StrictMixedType();
        }
        if (!$this->checkNullables && !$acceptingType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType && !$acceptedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType && !$acceptedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType) {
            $acceptedType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::removeNull($acceptedType);
        }
        if ($acceptingType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType && !$acceptedType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            foreach ($acceptingType->getTypes() as $innerType) {
                if (self::accepts($innerType, $acceptedType, $strictTypes)) {
                    return \true;
                }
            }
            return \false;
        }
        if ($acceptedType->isArray()->yes() && $acceptingType->isArray()->yes() && !$acceptingType->isIterableAtLeastOnce()->yes() && \count(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($acceptedType)) === 0 && \count(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantArrays($acceptingType)) === 0) {
            return self::accepts($acceptingType->getIterableKeyType(), $acceptedType->getIterableKeyType(), $strictTypes) && self::accepts($acceptingType->getIterableValueType(), $acceptedType->getIterableValueType(), $strictTypes);
        }
        $accepts = $acceptingType->accepts($acceptedType, $strictTypes);
        return $this->checkUnionTypes ? $accepts->yes() : !$accepts->no();
    }
    /**
     * @param Scope $scope
     * @param Expr $var
     * @param string $unknownClassErrorPattern
     * @param callable(Type $type): bool $unionTypeCriteriaCallback
     * @return FoundTypeResult
     */
    public function findTypeToCheck(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $var, string $unknownClassErrorPattern, callable $unionTypeCriteriaCallback) : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult
    {
        if ($this->checkThisOnly && !$this->isThis($var)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType(), [], []);
        }
        $type = $scope->getType($var);
        if (!$this->checkNullables && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NullType) {
            $type = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::removeNull($type);
        }
        if (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::containsNull($type)) {
            $type = $scope->getType($this->getNullsafeShortcircuitedExpr($var));
        }
        if ($this->checkExplicitMixed && $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType && $type->isExplicitMixed()) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StrictMixedType(), [], []);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType || $type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType(), [], []);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
            $type = $type->getStaticObjectType();
        }
        $errors = [];
        $directClassNames = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getDirectClassNames($type);
        $hasClassExistsClass = \false;
        foreach ($directClassNames as $referencedClass) {
            if ($this->reflectionProvider->hasClass($referencedClass)) {
                $classReflection = $this->reflectionProvider->getClass($referencedClass);
                if (!$classReflection->isTrait()) {
                    continue;
                }
            }
            if ($scope->isInClassExists($referencedClass)) {
                $hasClassExistsClass = \true;
                continue;
            }
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($unknownClassErrorPattern, $referencedClass))->line($var->getLine())->discoveringSymbolsTip()->build();
        }
        if (\count($errors) > 0 || $hasClassExistsClass) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType(), [], $errors);
        }
        if (!$this->checkUnionTypes) {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType(), [], []);
            }
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
                $newTypes = [];
                foreach ($type->getTypes() as $innerType) {
                    if (!$unionTypeCriteriaCallback($innerType)) {
                        continue;
                    }
                    $newTypes[] = $innerType;
                }
                if (\count($newTypes) > 0) {
                    return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::union(...$newTypes), $directClassNames, []);
                }
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FoundTypeResult($type, $directClassNames, []);
    }
    private function getNullsafeShortcircuitedExpr(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expr) : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr
    {
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafeMethodCall) {
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall) {
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name, $expr->args);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall && $expr->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name, $expr->args);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch) {
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->dim);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafePropertyFetch) {
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch($this->getNullsafeShortcircuitedExpr($expr->var), $expr->name);
        }
        if ($expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch && $expr->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            return new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch($this->getNullsafeShortcircuitedExpr($expr->class), $expr->name);
        }
        return $expr;
    }
}
