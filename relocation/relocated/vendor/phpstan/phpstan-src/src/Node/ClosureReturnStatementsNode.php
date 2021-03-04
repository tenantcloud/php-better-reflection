<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Yield_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\YieldFrom;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult;
class ClosureReturnStatementsNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\ReturnStatementsNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure $closureExpr;
    /** @var \PHPStan\Node\ReturnStatement[] */
    private array $returnStatements;
    /** @var array<int, Yield_|YieldFrom> */
    private array $yieldStatements;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult $statementResult;
    /**
     * @param \PhpParser\Node\Expr\Closure $closureExpr
     * @param \PHPStan\Node\ReturnStatement[] $returnStatements
     * @param array<int, Yield_|YieldFrom> $yieldStatements
     * @param \PHPStan\Analyser\StatementResult $statementResult
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure $closureExpr, array $returnStatements, array $yieldStatements, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult $statementResult)
    {
        parent::__construct($closureExpr->getAttributes());
        $this->closureExpr = $closureExpr;
        $this->returnStatements = $returnStatements;
        $this->yieldStatements = $yieldStatements;
        $this->statementResult = $statementResult;
    }
    public function getClosureExpr() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure
    {
        return $this->closureExpr;
    }
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array
    {
        return $this->returnStatements;
    }
    /**
     * @return array<int, Yield_|YieldFrom>
     */
    public function getYieldStatements() : array
    {
        return $this->yieldStatements;
    }
    public function getStatementResult() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult
    {
        return $this->statementResult;
    }
    public function returnsByRef() : bool
    {
        return $this->closureExpr->byRef;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClosureReturnStatementsNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
