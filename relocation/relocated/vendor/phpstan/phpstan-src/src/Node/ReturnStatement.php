<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
class ReturnStatement
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope;
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_ $returnNode;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_ $returnNode)
    {
        $this->scope = $scope;
        $this->returnNode = $returnNode;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getReturnNode() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Return_
    {
        return $this->returnNode;
    }
}
