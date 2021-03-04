<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Analyser;

use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
/**
 * @internal
 */
class DirectScopeFactory implements \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\ScopeFactory
{
    private string $scopeClass;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider;
    private \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver;
    private bool $treatPhpDocTypesAsCertain;
    private bool $objectFromNewClass;
    /** @var string[] */
    private array $dynamicConstantNames;
    public function __construct(string $scopeClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider, \TenantCloud\BetterReflection\Relocated\PhpParser\PrettyPrinter\Standard $printer, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, \TenantCloud\BetterReflection\Relocated\PHPStan\Parser\Parser $parser, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, bool $treatPhpDocTypesAsCertain, bool $objectFromNewClass, \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Container $container)
    {
        $this->scopeClass = $scopeClass;
        $this->reflectionProvider = $reflectionProvider;
        $this->dynamicReturnTypeExtensionRegistryProvider = $dynamicReturnTypeExtensionRegistryProvider;
        $this->operatorTypeSpecifyingExtensionRegistryProvider = $operatorTypeSpecifyingExtensionRegistryProvider;
        $this->printer = $printer;
        $this->typeSpecifier = $typeSpecifier;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->parser = $parser;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
        $this->objectFromNewClass = $objectFromNewClass;
        $this->dynamicConstantNames = $container->getParameter('dynamicConstantNames');
    }
    /**
     * @param \PHPStan\Analyser\ScopeContext $context
     * @param bool $declareStrictTypes
     * @param  array<string, Type> $constantTypes
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
        return new $scopeClass($this, $this->reflectionProvider, $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry(), $this->operatorTypeSpecifyingExtensionRegistryProvider->getRegistry(), $this->printer, $this->typeSpecifier, $this->propertyReflectionFinder, $this->parser, $this->nodeScopeResolver, $context, $declareStrictTypes, $constantTypes, $function, $namespace, $variablesTypes, $moreSpecificTypes, $conditionalExpressions, $inClosureBindScopeClass, $anonymousFunctionReflection, $inFirstLevelStatement, $currentlyAssignedExpressions, $nativeExpressionTypes, $inFunctionCallsStack, $this->dynamicConstantNames, $this->treatPhpDocTypesAsCertain, $this->objectFromNewClass, $afterExtractCall, $parentScope);
    }
}
