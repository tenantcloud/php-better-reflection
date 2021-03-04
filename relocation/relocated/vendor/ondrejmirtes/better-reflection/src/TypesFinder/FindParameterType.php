<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder;

use LogicException;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlock\Tags\Param;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\DocBlockFactory;
use TenantCloud\BetterReflection\Relocated\phpDocumentor\Reflection\Type;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Error;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param as ParamNode;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunctionAbstract;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
use function explode;
class FindParameterType
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
     * Given a function and parameter, attempt to find the type of the parameter.
     *
     * @return Type[]
     */
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunctionAbstract $function, ?\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Namespace_ $namespace, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Param $node) : array
    {
        $docComment = $function->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Param[] $paramTags */
        $paramTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('param');
        foreach ($paramTags as $paramTag) {
            if ($node->var instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\Error) {
                throw new \LogicException('PhpParser left an "Error" node in the parameters AST, this should NOT happen');
            }
            if ($paramTag->getVariableName() === $node->var->name) {
                return $this->resolveTypes->__invoke(\explode('|', (string) $paramTag->getType()), $context);
            }
        }
        return [];
    }
}
