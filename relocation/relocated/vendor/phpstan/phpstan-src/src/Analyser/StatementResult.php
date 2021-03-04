<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt;
class StatementResult
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope;
    private bool $hasYield;
    private bool $isAlwaysTerminating;
    /** @var StatementExitPoint[] */
    private array $exitPoints;
    /**
     * @param MutatingScope $scope
     * @param bool $hasYield
     * @param bool $isAlwaysTerminating
     * @param StatementExitPoint[] $exitPoints
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope $scope, bool $hasYield, bool $isAlwaysTerminating, array $exitPoints)
    {
        $this->scope = $scope;
        $this->hasYield = $hasYield;
        $this->isAlwaysTerminating = $isAlwaysTerminating;
        $this->exitPoints = $exitPoints;
    }
    public function getScope() : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
    public function hasYield() : bool
    {
        return $this->hasYield;
    }
    public function isAlwaysTerminating() : bool
    {
        return $this->isAlwaysTerminating;
    }
    public function filterOutLoopExitPoints() : self
    {
        if (!$this->isAlwaysTerminating) {
            return $this;
        }
        foreach ($this->exitPoints as $exitPoint) {
            $statement = $exitPoint->getStatement();
            if (!$statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Break_ && !$statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Continue_) {
                continue;
            }
            $num = $statement->num;
            if (!$num instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber) {
                return new self($this->scope, $this->hasYield, \false, $this->exitPoints);
            }
            if ($num->value !== 1) {
                continue;
            }
            return new self($this->scope, $this->hasYield, \false, $this->exitPoints);
        }
        return $this;
    }
    /**
     * @return StatementExitPoint[]
     */
    public function getExitPoints() : array
    {
        return $this->exitPoints;
    }
    /**
     * @param class-string<Stmt\Continue_>|class-string<Stmt\Break_> $stmtClass
     * @return StatementExitPoint[]
     */
    public function getExitPointsByType(string $stmtClass) : array
    {
        $exitPoints = [];
        foreach ($this->exitPoints as $exitPoint) {
            $statement = $exitPoint->getStatement();
            if (!$statement instanceof $stmtClass) {
                continue;
            }
            $value = $statement->num;
            if ($value === null) {
                $exitPoints[] = $exitPoint;
                continue;
            }
            if (!$value instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber) {
                $exitPoints[] = $exitPoint;
                continue;
            }
            $value = $value->value;
            if ($value !== 1) {
                continue;
            }
            $exitPoints[] = $exitPoint;
        }
        return $exitPoints;
    }
    /**
     * @return StatementExitPoint[]
     */
    public function getExitPointsForOuterLoop() : array
    {
        $exitPoints = [];
        foreach ($this->exitPoints as $exitPoint) {
            $statement = $exitPoint->getStatement();
            if (!$statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Continue_ && !$statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Break_) {
                continue;
            }
            if ($statement->num === null) {
                continue;
            }
            if (!$statement->num instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber) {
                continue;
            }
            $value = $statement->num->value;
            if ($value === 1) {
                continue;
            }
            $newNode = null;
            if ($value > 2) {
                $newNode = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\LNumber($value - 1);
            }
            if ($statement instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Continue_) {
                $newStatement = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Continue_($newNode);
            } else {
                $newStatement = new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Break_($newNode);
            }
            $exitPoints[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\StatementExitPoint($newStatement, $exitPoint->getScope());
        }
        return $exitPoints;
    }
}
