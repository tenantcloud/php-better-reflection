<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class CallToFunctionParametersRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck $check;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FunctionCallParametersCheck $check)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            return [];
        }
        if (!$this->reflectionProvider->hasFunction($node->name, $scope)) {
            return [];
        }
        $function = $this->reflectionProvider->getFunction($node->name, $scope);
        return $this->check->check(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $function->getVariants()), $scope, $function->isBuiltin(), $node, ['Function ' . $function->getName() . ' invoked with %d parameter, %d required.', 'Function ' . $function->getName() . ' invoked with %d parameters, %d required.', 'Function ' . $function->getName() . ' invoked with %d parameter, at least %d required.', 'Function ' . $function->getName() . ' invoked with %d parameters, at least %d required.', 'Function ' . $function->getName() . ' invoked with %d parameter, %d-%d required.', 'Function ' . $function->getName() . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of function ' . $function->getName() . ' expects %s, %s given.', 'Result of function ' . $function->getName() . ' (void) is used.', 'Parameter %s of function ' . $function->getName() . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to function ' . $function->getName(), 'Missing parameter $%s in call to function ' . $function->getName() . '.', 'Unknown parameter $%s in call to function ' . $function->getName() . '.']);
    }
}
