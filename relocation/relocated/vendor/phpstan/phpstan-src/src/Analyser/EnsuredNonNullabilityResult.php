<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

class EnsuredNonNullabilityResult
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope;
    /** @var EnsuredNonNullabilityResultExpression[] */
    private array $specifiedExpressions;
    /**
     * @param MutatingScope $scope
     * @param EnsuredNonNullabilityResultExpression[] $specifiedExpressions
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope, array $specifiedExpressions)
    {
        $this->scope = $scope;
        $this->specifiedExpressions = $specifiedExpressions;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
    /**
     * @return EnsuredNonNullabilityResultExpression[]
     */
    public function getSpecifiedExpressions() : array
    {
        return $this->specifiedExpressions;
    }
}
