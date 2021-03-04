<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
class MemoizingReflectionProvider implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $provider;
    /** @var array<string, bool> */
    private array $hasClasses = [];
    /** @var array<string, \PHPStan\Reflection\ClassReflection> */
    private array $classes = [];
    /** @var array<string, string> */
    private array $classNames = [];
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $provider)
    {
        $this->provider = $provider;
    }
    public function hasClass(string $className) : bool
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->hasClasses[$lowerClassName])) {
            return $this->hasClasses[$lowerClassName];
        }
        return $this->hasClasses[$lowerClassName] = $this->provider->hasClass($className);
    }
    public function getClass(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->classes[$lowerClassName])) {
            return $this->classes[$lowerClassName];
        }
        return $this->classes[$lowerClassName] = $this->provider->getClass($className);
    }
    public function getClassName(string $className) : string
    {
        $lowerClassName = \strtolower($className);
        if (isset($this->classNames[$lowerClassName])) {
            return $this->classNames[$lowerClassName];
        }
        return $this->classNames[$lowerClassName] = $this->provider->getClassName($className);
    }
    public function supportsAnonymousClasses() : bool
    {
        return $this->provider->supportsAnonymousClasses();
    }
    public function getAnonymousClassReflection(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $classNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->provider->getAnonymousClassReflection($classNode, $scope);
    }
    public function hasFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasFunction($nameNode, $scope);
    }
    public function getFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection
    {
        return $this->provider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->provider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->provider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->provider->resolveConstantName($nameNode, $scope);
    }
}
