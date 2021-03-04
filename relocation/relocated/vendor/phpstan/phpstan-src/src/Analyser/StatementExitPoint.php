<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt;
class StatementExitPoint
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt $statement;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt $statement, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
