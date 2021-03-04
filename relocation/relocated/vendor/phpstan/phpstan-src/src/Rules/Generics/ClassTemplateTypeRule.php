<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassNode;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
/**
 * @implements \PHPStan\Rules\Rule<InClassNode>
 */
class ClassTemplateTypeRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck $templateTypeCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\TemplateTypeCheck $templateTypeCheck)
    {
        $this->templateTypeCheck = $templateTypeCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Node\InClassNode::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            return [];
        }
        $classReflection = $scope->getClassReflection();
        $className = $classReflection->getName();
        if ($classReflection->isAnonymous()) {
            $displayName = 'anonymous class';
        } else {
            $displayName = 'class ' . $classReflection->getDisplayName();
        }
        return $this->templateTypeCheck->check($node, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope::createWithClass($className), $classReflection->getTemplateTags(), \sprintf('PHPDoc tag @template for %s cannot have existing class %%s as its name.', $displayName), \sprintf('PHPDoc tag @template for %s cannot have existing type alias %%s as its name.', $displayName), \sprintf('PHPDoc tag @template %%s for %s has invalid bound type %%s.', $displayName), \sprintf('PHPDoc tag @template %%s for %s with bound type %%s is not supported.', $displayName));
    }
}
