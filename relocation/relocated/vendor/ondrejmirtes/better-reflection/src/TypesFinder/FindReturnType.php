<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder;

use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock\Tags\Return_;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlockFactory;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunctionAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
use function explode;
class FindReturnType
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
     * Given a function, attempt to find the return type.
     *
     * @return Type[]
     */
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunctionAbstract $function, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $docComment = $function->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Return_[] $returnTags */
        $returnTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('return');
        foreach ($returnTags as $returnTag) {
            return $this->resolveTypes->__invoke(\explode('|', (string) $returnTag->getType()), $context);
        }
        return [];
    }
}
