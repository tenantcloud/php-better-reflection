<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node\Property;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class PropertyWrite
{
    /** @var PropertyFetch|StaticPropertyFetch */
    private $fetch;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope;
    /**
     * PropertyWrite constructor.
     *
     * @param PropertyFetch|StaticPropertyFetch $fetch
     * @param Scope $scope
     */
    public function __construct($fetch, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope)
    {
        $this->fetch = $fetch;
        $this->scope = $scope;
    }
    /**
     * @return PropertyFetch|StaticPropertyFetch
     */
    public function getFetch()
    {
        return $this->fetch;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
