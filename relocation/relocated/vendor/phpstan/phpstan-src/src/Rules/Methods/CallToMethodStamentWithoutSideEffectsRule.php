<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Methods;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToMethodStamentWithoutSideEffectsRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\NullsafeMethodCall) {
            $scope = $scope->filterByTruthyValue(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\NotIdentical($node->expr->var, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name('null'))));
        } elseif (!$node->expr instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\MethodCall) {
            return [];
        }
        $methodCall = $node->expr;
        if (!$methodCall->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $methodCall->name->toString();
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $methodCall->var, '', static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($methodName) : bool {
            return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
        });
        $calledOnType = $typeResult->getType();
        if ($calledOnType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
            return [];
        }
        if (!$calledOnType->canCallMethods()->yes()) {
            return [];
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return [];
        }
        $method = $calledOnType->getMethod($methodName, $scope);
        if ($method->hasSideEffects()->no()) {
            $throwsType = $method->getThrowType();
            if ($throwsType !== null && !$throwsType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\VoidType) {
                return [];
            }
            $methodResult = $scope->getType($methodCall);
            if ($methodResult instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\NeverType && $methodResult->isExplicit()) {
                return [];
            }
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s::%s() on a separate line has no effect.', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        return [];
    }
}
