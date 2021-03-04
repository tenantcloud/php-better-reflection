<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
class AnonymousClassNameRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::class;
    }
    /**
     * @param Class_ $node
     * @param Scope $scope
     * @return string[]
     */
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        $className = isset($node->namespacedName) ? (string) $node->namespacedName : (string) $node->name;
        try {
            $this->reflectionProvider->getClass($className);
        } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\ClassNotFoundException $e) {
            return ['not found'];
        }
        return ['found'];
    }
}
