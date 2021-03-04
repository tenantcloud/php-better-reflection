<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node\Constant;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class ClassConstantFetch
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch $node;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }
    public function getNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->node;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
}
