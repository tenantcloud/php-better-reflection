<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Functions;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToFunctionStamentWithoutSideEffectsRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\FuncCall) {
            return [];
        }
        $funcCall = $node->expr;
        if (!$funcCall->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            return [];
        }
        if (!$this->reflectionProvider->hasFunction($funcCall->name, $scope)) {
            return [];
        }
        $function = $this->reflectionProvider->getFunction($funcCall->name, $scope);
        if ($function->hasSideEffects()->no()) {
            $throwsType = $function->getThrowType();
            if ($throwsType !== null && !$throwsType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType) {
                return [];
            }
            $functionResult = $scope->getType($funcCall);
            if ($functionResult instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && $functionResult->isExplicit()) {
                return [];
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function %s() on a separate line has no effect.', $function->getName()))->build()];
        }
        return [];
    }
}
