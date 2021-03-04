<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\Constant\ClassConstantFetch;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\Property\PropertyRead;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\Property\PropertyWrite;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
class ClassStatementsGatherer
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection;
    /** @var callable(\PhpParser\Node $node, Scope $scope): void */
    private $nodeCallback;
    /** @var ClassPropertyNode[] */
    private array $properties = [];
    /** @var \PhpParser\Node\Stmt\ClassMethod[] */
    private array $methods = [];
    /** @var \PHPStan\Node\Method\MethodCall[] */
    private array $methodCalls = [];
    /** @var array<int, PropertyWrite|PropertyRead> */
    private array $propertyUsages = [];
    /** @var \PhpParser\Node\Stmt\ClassConst[] */
    private array $constants = [];
    /** @var ClassConstantFetch[] */
    private array $constantFetches = [];
    /**
     * @param ClassReflection $classReflection
     * @param callable(\PhpParser\Node $node, Scope $scope): void $nodeCallback
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection, callable $nodeCallback)
    {
        $this->classReflection = $classReflection;
        $this->nodeCallback = $nodeCallback;
    }
    /**
     * @return ClassPropertyNode[]
     */
    public function getProperties() : array
    {
        return $this->properties;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassMethod[]
     */
    public function getMethods() : array
    {
        return $this->methods;
    }
    /**
     * @return Method\MethodCall[]
     */
    public function getMethodCalls() : array
    {
        return $this->methodCalls;
    }
    /**
     * @return array<int, PropertyWrite|PropertyRead>
     */
    public function getPropertyUsages() : array
    {
        return $this->propertyUsages;
    }
    /**
     * @return \PhpParser\Node\Stmt\ClassConst[]
     */
    public function getConstants() : array
    {
        return $this->constants;
    }
    /**
     * @return ClassConstantFetch[]
     */
    public function getConstantFetches() : array
    {
        return $this->constantFetches;
    }
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : void
    {
        $nodeCallback = $this->nodeCallback;
        $nodeCallback($node, $scope);
        $this->gatherNodes($node, $scope);
    }
    private function gatherNodes(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : void
    {
        if (!$scope->isInClass()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        if ($scope->getClassReflection()->getName() !== $this->classReflection->getName()) {
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Node\ClassPropertyNode && !$scope->isInTrait()) {
            $this->properties[] = $node;
            if ($node->isPromoted()) {
                $this->propertyUsages[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Node\Property\PropertyWrite(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable('this'), new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier($node->getName())), $scope);
            }
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod && !$scope->isInTrait()) {
            $this->methods[] = $node;
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassConst) {
            $this->constants[] = $node;
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall || $node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticCall) {
            $this->methodCalls[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Node\Method\MethodCall($node, $scope);
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Array_ && \count($node->items) === 2) {
            $this->methodCalls[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Node\Method\MethodCall($node, $scope);
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch) {
            $this->constantFetches[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Node\Constant\ClassConstantFetch($node, $scope);
            return;
        }
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr) {
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $this->gatherNodes($node->var, $scope);
            return;
        }
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\EncapsedStringPart) {
            return;
        }
        $inAssign = $scope->isInExpressionAssign($node);
        while ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrayDimFetch) {
            $node = $node->var;
        }
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\StaticPropertyFetch) {
            return;
        }
        if ($inAssign) {
            $this->propertyUsages[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Node\Property\PropertyWrite($node, $scope);
        } else {
            $this->propertyUsages[] = new \TenantCloud\BetterReflection\Relocated\PHPStan\Node\Property\PropertyRead($node, $scope);
        }
    }
}
