<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult;
class MethodReturnStatementsNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\ReturnStatementsNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod $classMethod;
    /** @var \PHPStan\Node\ReturnStatement[] */
    private array $returnStatements;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult $statementResult;
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $method
     * @param \PHPStan\Node\ReturnStatement[] $returnStatements
     * @param \PHPStan\Analyser\StatementResult $statementResult
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod $method, array $returnStatements, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult $statementResult)
    {
        parent::__construct($method->getAttributes());
        $this->classMethod = $method;
        $this->returnStatements = $returnStatements;
        $this->statementResult = $statementResult;
    }
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array
    {
        return $this->returnStatements;
    }
    public function getStatementResult() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementResult
    {
        return $this->statementResult;
    }
    public function returnsByRef() : bool
    {
        return $this->classMethod->byRef;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_FunctionReturnStatementsNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
