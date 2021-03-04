<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Node;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod;
use TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\Method\MethodCall;
class ClassMethodsNode extends \TenantCloud\BetterReflection\Relocated\PhpParser\NodeAbstract implements \TenantCloud\BetterReflection\Relocated\PHPStan\Node\VirtualNode
{
    private \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike $class;
    /** @var ClassMethod[] */
    private array $methods;
    /** @var array<int, MethodCall> */
    private array $methodCalls;
    /**
     * @param ClassLike $class
     * @param ClassMethod[] $methods
     * @param array<int, MethodCall> $methodCalls
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike $class, array $methods, array $methodCalls)
    {
        parent::__construct($class->getAttributes());
        $this->class = $class;
        $this->methods = $methods;
        $this->methodCalls = $methodCalls;
    }
    public function getClass() : \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassLike
    {
        return $this->class;
    }
    /**
     * @return ClassMethod[]
     */
    public function getMethods() : array
    {
        return $this->methods;
    }
    /**
     * @return array<int, MethodCall>
     */
    public function getMethodCalls() : array
    {
        return $this->methodCalls;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClassMethodsNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
