<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ExtendsTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ImplementsTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Interface_>
 */
class InterfaceAncestorsRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericAncestorsCheck $genericAncestorsCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericAncestorsCheck $genericAncestorsCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->genericAncestorsCheck = $genericAncestorsCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Interface_::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!isset($node->namespacedName)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $interfaceName = (string) $node->namespacedName;
        $extendsTags = [];
        $implementsTags = [];
        $docComment = $node->getDocComment();
        if ($docComment !== null) {
            $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $interfaceName, null, null, $docComment->getText());
            $extendsTags = $resolvedPhpDoc->getExtendsTags();
            $implementsTags = $resolvedPhpDoc->getImplementsTags();
        }
        $extendsErrors = $this->genericAncestorsCheck->check($node->extends, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ExtendsTag $tag) : Type {
            return $tag->getType();
        }, $extendsTags), \sprintf('Interface %s @extends tag contains incompatible type %%s.', $interfaceName), \sprintf('Interface %s has @extends tag, but does not extend any interface.', $interfaceName), \sprintf('The @extends tag of interface %s describes %%s but the interface extends: %%s', $interfaceName), 'PHPDoc tag @extends contains generic type %s but interface %s is not generic.', 'Generic type %s in PHPDoc tag @extends does not specify all template types of interface %s: %s', 'Generic type %s in PHPDoc tag @extends specifies %d template types, but interface %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @extends is not subtype of template type %s of interface %s.', 'PHPDoc tag @extends has invalid type %s.', \sprintf('Interface %s extends generic interface %%s but does not specify its types: %%s', $interfaceName), \sprintf('in extended type %%s of interface %s', $interfaceName));
        $implementsErrors = $this->genericAncestorsCheck->check([], \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ImplementsTag $tag) : Type {
            return $tag->getType();
        }, $implementsTags), \sprintf('Interface %s @implements tag contains incompatible type %%s.', $interfaceName), \sprintf('Interface %s has @implements tag, but can not implement any interface, must extend from it.', $interfaceName), '', '', '', '', '', '', '', '');
        return \array_merge($extendsErrors, $implementsErrors);
    }
}
