<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Internal;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
class ScopeIsInClassTypeSpecifyingExtension implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MethodTypeSpecifyingExtension, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    private string $isInMethodName;
    private string $removeNullMethodName;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier;
    public function __construct(string $isInMethodName, string $removeNullMethodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->isInMethodName = $isInMethodName;
        $this->removeNullMethodName = $removeNullMethodName;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function setTypeSpecifier(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer::class;
    }
    public function isMethodSupported(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $methodReflection->getName() === $this->isInMethodName && !$context->null();
    }
    public function specifyTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\TypeSpecifierContext $context) : \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\SpecifiedTypes
    {
        $scopeClass = $this->reflectionProvider->getClass(\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope::class);
        $methodVariants = $scopeClass->getMethod($this->removeNullMethodName, $scope)->getVariants();
        return $this->typeSpecifier->create(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall($node->var, $this->removeNullMethodName), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::removeNull(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodVariants)->getReturnType()), $context);
    }
}
