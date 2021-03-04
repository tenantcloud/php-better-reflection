<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Broker;

use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\OperatorTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class Broker implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider;
    /** @var string[] */
    private array $universalObjectCratesClasses;
    private static ?\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker $instance = null;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider
     * @param \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider
     * @param string[] $universalObjectCratesClasses
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider, array $universalObjectCratesClasses)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->dynamicReturnTypeExtensionRegistryProvider = $dynamicReturnTypeExtensionRegistryProvider;
        $this->operatorTypeSpecifyingExtensionRegistryProvider = $operatorTypeSpecifyingExtensionRegistryProvider;
        $this->universalObjectCratesClasses = $universalObjectCratesClasses;
    }
    public static function registerInstance(\TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker $reflectionProvider) : void
    {
        self::$instance = $reflectionProvider;
    }
    public static function getInstance() : \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker
    {
        if (self::$instance === null) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return self::$instance;
    }
    public function hasClass(string $className) : bool
    {
        return $this->reflectionProvider->hasClass($className);
    }
    public function getClass(string $className) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->reflectionProvider->getClass($className);
    }
    public function getClassName(string $className) : string
    {
        return $this->reflectionProvider->getClassName($className);
    }
    public function supportsAnonymousClasses() : bool
    {
        return $this->reflectionProvider->supportsAnonymousClasses();
    }
    public function getAnonymousClassReflection(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_ $classNode, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->reflectionProvider->getAnonymousClassReflection($classNode, $scope);
    }
    public function hasFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasFunction($nameNode, $scope);
    }
    public function getFunction(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionReflection
    {
        return $this->reflectionProvider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->reflectionProvider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name $nameNode, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveConstantName($nameNode, $scope);
    }
    /**
     * @return string[]
     */
    public function getUniversalObjectCratesClasses() : array
    {
        return $this->universalObjectCratesClasses;
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\DynamicMethodReturnTypeExtension[]
     */
    public function getDynamicMethodReturnTypeExtensionsForClass(string $className) : array
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry()->getDynamicMethodReturnTypeExtensionsForClass($className);
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[]
     */
    public function getDynamicStaticMethodReturnTypeExtensionsForClass(string $className) : array
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry()->getDynamicStaticMethodReturnTypeExtensionsForClass($className);
    }
    /**
     * @return OperatorTypeSpecifyingExtension[]
     */
    public function getOperatorTypeSpecifyingExtensions(string $operator, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $leftType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $rightType) : array
    {
        return $this->operatorTypeSpecifyingExtensionRegistryProvider->getRegistry()->getOperatorTypeSpecifyingExtensions($operator, $leftType, $rightType);
    }
    /**
     * @return \PHPStan\Type\DynamicFunctionReturnTypeExtension[]
     */
    public function getDynamicFunctionReturnTypeExtensions() : array
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry()->getDynamicFunctionReturnTypeExtensions();
    }
    /**
     * @internal
     * @return DynamicReturnTypeExtensionRegistryProvider
     */
    public function getDynamicReturnTypeExtensionRegistryProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider;
    }
    /**
     * @internal
     * @return \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
     */
    public function getOperatorTypeSpecifyingExtensionRegistryProvider() : \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->operatorTypeSpecifyingExtensionRegistryProvider;
    }
}
