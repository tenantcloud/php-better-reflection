<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class NewStaticRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\New_::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            return [];
        }
        if (!$scope->isInClass()) {
            return [];
        }
        if (\strtolower($node->class->toString()) !== 'static') {
            return [];
        }
        $classReflection = $scope->getClassReflection();
        if ($classReflection->isFinal()) {
            return [];
        }
        $messages = [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Unsafe usage of new static().')->tip('See: https://phpstan.org/blog/solving-phpstan-error-unsafe-usage-of-new-static')->build()];
        if (!$classReflection->hasConstructor()) {
            return $messages;
        }
        $constructor = $classReflection->getConstructor();
        if ($constructor->getPrototype()->getDeclaringClass()->isInterface()) {
            return [];
        }
        if ($constructor instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpMethodReflection) {
            if ($constructor->isFinal()->yes()) {
                return [];
            }
            $prototype = $constructor->getPrototype();
            if ($prototype->isAbstract()) {
                return [];
            }
        }
        return $messages;
    }
}
