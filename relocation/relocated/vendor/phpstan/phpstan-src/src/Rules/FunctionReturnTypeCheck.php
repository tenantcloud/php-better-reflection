<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\GenericTypeVariableResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
class FunctionReturnTypeCheck
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PHPStan\Type\Type $returnType
     * @param \PhpParser\Node\Expr|null $returnValue
     * @param string $emptyReturnStatementMessage
     * @param string $voidMessage
     * @param string $typeMismatchMessage
     * @param bool $isGenerator
     * @return RuleError[]
     */
    public function checkReturnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $returnType, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $returnValue, \TenantCloud\BetterReflection\Relocated\PhpParser\Node $returnNode, string $emptyReturnStatementMessage, string $voidMessage, string $typeMismatchMessage, string $neverMessage, bool $isGenerator) : array
    {
        if ($returnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message($neverMessage)->line($returnNode->getLine())->build()];
        }
        if ($isGenerator) {
            if (!$returnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName) {
                return [];
            }
            $returnType = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
            if ($returnType === null) {
                return [];
            }
        }
        $isVoidSuperType = (new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType())->isSuperTypeOf($returnType);
        $verbosityLevel = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType, null);
        if ($returnValue === null) {
            if (!$isVoidSuperType->no()) {
                return [];
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($emptyReturnStatementMessage, $returnType->describe($verbosityLevel)))->line($returnNode->getLine())->build()];
        }
        $returnValueType = $scope->getType($returnValue);
        $verbosityLevel = \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($returnType, $returnValueType);
        if ($isVoidSuperType->yes()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($voidMessage, $returnValueType->describe($verbosityLevel)))->line($returnNode->getLine())->build()];
        }
        if (!$this->ruleLevelHelper->accepts($returnType, $returnValueType, $scope->isDeclareStrictTypes())) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($typeMismatchMessage, $returnType->describe($verbosityLevel), $returnValueType->describe($verbosityLevel)))->line($returnNode->getLine())->build()];
        }
        return [];
    }
}
