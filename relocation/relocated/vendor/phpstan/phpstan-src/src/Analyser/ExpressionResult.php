<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

class ExpressionResult
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope;
    private bool $hasYield;
    /** @var (callable(): MutatingScope)|null */
    private $truthyScopeCallback;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $truthyScope = null;
    /** @var (callable(): MutatingScope)|null */
    private $falseyScopeCallback;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $falseyScope = null;
    /**
     * @param MutatingScope $scope
     * @param bool $hasYield
     * @param (callable(): MutatingScope)|null $truthyScopeCallback
     * @param (callable(): MutatingScope)|null $falseyScopeCallback
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope, bool $hasYield, ?callable $truthyScopeCallback = null, ?callable $falseyScopeCallback = null)
    {
        $this->scope = $scope;
        $this->hasYield = $hasYield;
        $this->truthyScopeCallback = $truthyScopeCallback;
        $this->falseyScopeCallback = $falseyScopeCallback;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
    public function hasYield() : bool
    {
        return $this->hasYield;
    }
    public function getTruthyScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope
    {
        if ($this->truthyScopeCallback === null) {
            return $this->scope;
        }
        if ($this->truthyScope !== null) {
            return $this->truthyScope;
        }
        $callback = $this->truthyScopeCallback;
        $this->truthyScope = $callback();
        return $this->truthyScope;
    }
    public function getFalseyScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope
    {
        if ($this->falseyScopeCallback === null) {
            return $this->scope;
        }
        if ($this->falseyScope !== null) {
            return $this->falseyScope;
        }
        $callback = $this->falseyScopeCallback;
        $this->falseyScope = $callback();
        return $this->falseyScope;
    }
}
