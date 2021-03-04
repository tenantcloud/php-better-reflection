<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Classes;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node>
 */
class InvalidPromotedPropertiesRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ArrowFunction && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Closure && !$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Function_) {
            return [];
        }
        $hasPromotedProperties = \false;
        foreach ($node->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            $hasPromotedProperties = \true;
            break;
        }
        if (!$hasPromotedProperties) {
            return [];
        }
        if (!$this->phpVersion->supportsPromotedProperties()) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
        }
        if (!$node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod || $node->name->toLowerString() !== '__construct') {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties can be in constructor only.')->nonIgnorable()->build()];
        }
        if ($node->stmts === null) {
            return [\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message('Promoted properties are not allowed in abstract constructors.')->nonIgnorable()->build()];
        }
        $errors = [];
        foreach ($node->params as $param) {
            if ($param->flags === 0) {
                continue;
            }
            if (!$param->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
            }
            if (!$param->variadic) {
                continue;
            }
            $propertyName = $param->var->name;
            $errors[] = \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Promoted property parameter $%s can not be variadic.', $propertyName))->nonIgnorable()->line($param->getLine())->build();
            continue;
        }
        return $errors;
    }
}
