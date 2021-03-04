<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
