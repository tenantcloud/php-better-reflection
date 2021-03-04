<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class LazyScopeFactory implements \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory
{
    private string $scopeClass;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container;
    /** @var string[] */
    private array $dynamicConstantNames;
    private bool $treatPhpDocTypesAsCertain;
    private bool $objectFromNewClass;
    public function __construct(string $scopeClass, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->scopeClass = $scopeClass;
        $this->container = $container;
        $this->dynamicConstantNames = $container->getParameter('dynamicConstantNames');
        $this->treatPhpDocTypesAsCertain = $container->getParameter('treatPhpDocTypesAsCertain');
        $this->objectFromNewClass = $container->getParameter('featureToggles')['objectFromNewClass'];
    }
    /**
     * @param \PHPStan\Analyser\ScopeContext $context
     * @param bool $declareStrictTypes
     * @param array<string, Type> $constantTypes
     * @param \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|null $function
     * @param string|null $namespace
     * @param \PHPStan\Analyser\VariableTypeHolder[] $variablesTypes
     * @param \PHPStan\Analyser\VariableTypeHolder[] $moreSpecificTypes
     * @param array<string, ConditionalExpressionHolder[]> $conditionalExpressions
     * @param string|null $inClosureBindScopeClass
     * @param \PHPStan\Reflection\ParametersAcceptor|null $anonymousFunctionReflection
     * @param bool $inFirstLevelStatement
     * @param array<string, true> $currentlyAssignedExpressions
     * @param array<string, Type> $nativeExpressionTypes
     * @param array<\PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection> $inFunctionCallsStack
     * @param bool $afterExtractCall
     * @param Scope|null $parentScope
     *
     * @return MutatingScope
     */
    public function create(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeContext $context, bool $declareStrictTypes = \false, array $constantTypes = [], $function = null, ?string $namespace = null, array $variablesTypes = [], array $moreSpecificTypes = [], array $conditionalExpressions = [], ?string $inClosureBindScopeClass = null, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $anonymousFunctionReflection = null, bool $inFirstLevelStatement = \true, array $currentlyAssignedExpressions = [], array $nativeExpressionTypes = [], array $inFunctionCallsStack = [], bool $afterExtractCall = \false, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $parentScope = null) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope
    {
        $scopeClass = $this->scopeClass;
        if (!\is_a($scopeClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\MutatingScope::class, \true)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        return new $scopeClass($this, $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class)->getRegistry(), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class)->getRegistry(), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser::class), $this->container->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver::class), $context, $declareStrictTypes, $constantTypes, $function, $namespace, $variablesTypes, $moreSpecificTypes, $conditionalExpressions, $inClosureBindScopeClass, $anonymousFunctionReflection, $inFirstLevelStatement, $currentlyAssignedExpressions, $nativeExpressionTypes, $inFunctionCallsStack, $this->dynamicConstantNames, $this->treatPhpDocTypesAsCertain, $this->objectFromNewClass, $afterExtractCall, $parentScope);
    }
}
