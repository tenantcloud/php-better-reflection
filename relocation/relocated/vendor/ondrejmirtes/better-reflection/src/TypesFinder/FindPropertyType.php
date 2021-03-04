<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock\Tags\Var_;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlockFactory;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
use function array_map;
use function array_merge;
use function explode;
class FindPropertyType
{
    /** @var ResolveTypes */
    private $resolveTypes;
    /** @var DocBlockFactory */
    private $docBlockFactory;
    /** @var NamespaceNodeToReflectionTypeContext */
    private $makeContext;
    public function __construct()
    {
        $this->resolveTypes = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\ResolveTypes();
        $this->docBlockFactory = \TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->makeContext = new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext();
    }
    /**
     * Given a property, attempt to find the type of the property.
     *
     * @return Type[]
     */
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionProperty $reflectionProperty, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $docComment = $reflectionProperty->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Var_[] $varTags */
        $varTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('var');
        return \array_merge([], ...\array_map(function (\TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock\Tags\Var_ $varTag) use($context) {
            return $this->resolveTypes->__invoke(\explode('|', (string) $varTag->getType()), $context);
        }, $varTags));
    }
}
