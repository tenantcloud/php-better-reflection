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
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Class_>
 */
class ClassAncestorsRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
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
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Class_::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!isset($node->namespacedName)) {
            // anonymous class
            return [];
        }
        $className = (string) $node->namespacedName;
        $extendsTags = [];
        $implementsTags = [];
        $docComment = $node->getDocComment();
        if ($docComment !== null) {
            $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $className, null, null, $docComment->getText());
            $extendsTags = $resolvedPhpDoc->getExtendsTags();
            $implementsTags = $resolvedPhpDoc->getImplementsTags();
        }
        $extendsErrors = $this->genericAncestorsCheck->check($node->extends !== null ? [$node->extends] : [], \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ExtendsTag $tag) : Type {
            return $tag->getType();
        }, $extendsTags), \sprintf('Class %s @extends tag contains incompatible type %%s.', $className), \sprintf('Class %s has @extends tag, but does not extend any class.', $className), \sprintf('The @extends tag of class %s describes %%s but the class extends %%s.', $className), 'PHPDoc tag @extends contains generic type %s but class %s is not generic.', 'Generic type %s in PHPDoc tag @extends does not specify all template types of class %s: %s', 'Generic type %s in PHPDoc tag @extends specifies %d template types, but class %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @extends is not subtype of template type %s of class %s.', 'PHPDoc tag @extends has invalid type %s.', \sprintf('Class %s extends generic class %%s but does not specify its types: %%s', $className), \sprintf('in extended type %%s of class %s', $className));
        $implementsErrors = $this->genericAncestorsCheck->check($node->implements, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\ImplementsTag $tag) : Type {
            return $tag->getType();
        }, $implementsTags), \sprintf('Class %s @implements tag contains incompatible type %%s.', $className), \sprintf('Class %s has @implements tag, but does not implement any interface.', $className), \sprintf('The @implements tag of class %s describes %%s but the class implements: %%s', $className), 'PHPDoc tag @implements contains generic type %s but interface %s is not generic.', 'Generic type %s in PHPDoc tag @implements does not specify all template types of interface %s: %s', 'Generic type %s in PHPDoc tag @implements specifies %d template types, but interface %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @implements is not subtype of template type %s of interface %s.', 'PHPDoc tag @implements has invalid type %s.', \sprintf('Class %s implements generic interface %%s but does not specify its types: %%s', $className), \sprintf('in implemented type %%s of class %s', $className));
        return \array_merge($extendsErrors, $implementsErrors);
    }
}
