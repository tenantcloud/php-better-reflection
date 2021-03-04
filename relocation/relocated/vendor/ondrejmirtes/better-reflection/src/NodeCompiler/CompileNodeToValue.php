<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler;

use TenantCloud\BetterReflection\Relocated\PhpParser\ConstExprEvaluator;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper;
use function assert;
use function constant;
use function defined;
use function dirname;
use function realpath;
use function sprintf;
use function strtolower;
class CompileNodeToValue
{
    /**
     * Compile an expression from a node into a value.
     *
     * @param Node\Stmt\Expression|Node\Expr $node Node has to be processed by the PhpParser\NodeVisitor\NameResolver
     *
     * @return scalar|array<scalar>|null
     *
     * @throws Exception\UnableToCompileNode
     */
    public function __invoke(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $context)
    {
        if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\Expression) {
            return $this($node->expr, $context);
        }
        $constExprEvaluator = new \TenantCloud\BetterReflection\Relocated\PhpParser\ConstExprEvaluator(function (\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $node) use($context) {
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch) {
                return $this->compileConstFetch($node, $context);
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch) {
                return $this->compileClassConstFetch($node, $context);
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Dir) {
                return $this->compileDirConstant($context);
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Class_) {
                return $this->compileClassConstant($context);
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\File) {
                return $context->getFileName();
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Line) {
                return $node->getLine();
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Namespace_) {
                return $context->getNamespace() ?? '';
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Method) {
                if ($context->hasSelf()) {
                    if ($context->getFunctionName() !== null) {
                        return \sprintf('%s::%s', $context->getSelf()->getName(), $context->getFunctionName());
                    }
                    return '';
                }
                if ($context->getFunctionName() !== null) {
                    return $context->getFunctionName();
                }
                return '';
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Function_) {
                if ($context->getFunctionName() !== null) {
                    return $context->getFunctionName();
                }
                return '';
            }
            if ($node instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\MagicConst\Trait_) {
                if ($context->hasSelf()) {
                    $class = $context->getSelf();
                    if ($class->isTrait()) {
                        return $class->getName();
                    }
                }
                return '';
            }
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode::forUnRecognizedExpressionInContext($node, $context);
        });
        return $constExprEvaluator->evaluateDirectly($node);
    }
    /**
     * Compile constant expressions
     *
     * @return scalar|array<scalar>|null
     *
     * @throws Exception\UnableToCompileNode
     */
    private function compileConstFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch $constNode, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $context)
    {
        $constantName = $constNode->name->toString();
        switch (\strtolower($constantName)) {
            case 'null':
                return null;
            case 'false':
                return \false;
            case 'true':
                return \true;
            default:
                if ($context->getNamespace() !== null && !$constNode->name->isFullyQualified()) {
                    $namespacedName = \sprintf('%s\\%s', $context->getNamespace(), $constantName);
                    if (\defined($namespacedName)) {
                        return \constant($namespacedName);
                    }
                    try {
                        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant::createFromName($namespacedName)->getValue();
                    } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                        // pass
                    }
                }
                if (\defined($constantName)) {
                    return \constant($constantName);
                }
                try {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionConstant::createFromName($constantName)->getValue();
                } catch (\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                    throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode::becauseOfNotFoundConstantReference($context, $constNode);
                }
        }
    }
    /**
     * Compile class constants
     *
     * @return scalar|array<scalar>|null
     *
     * @throws IdentifierNotFound
     * @throws Exception\UnableToCompileNode If a referenced constant could not be located on the expected referenced class.
     */
    private function compileClassConstFetch(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch $node, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $context)
    {
        \assert($node->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier);
        $nodeName = $node->name->name;
        \assert($node->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name);
        $className = $node->class->toString();
        if ($nodeName === 'class') {
            return $this->resolveClassNameForClassNameConstant($className, $context);
        }
        $classInfo = null;
        if ($className === 'self' || $className === 'static') {
            $classInfo = $context->getSelf()->hasConstant($nodeName) ? $context->getSelf() : null;
        } elseif ($className === 'parent') {
            $classInfo = $context->getSelf()->getParentClass();
        }
        if ($classInfo === null) {
            $classInfo = $context->getReflector()->reflect($className);
            \assert($classInfo instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass);
        }
        $reflectionConstant = $classInfo->getReflectionConstant($nodeName);
        if (!$reflectionConstant instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClassConstant) {
            throw \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception\UnableToCompileNode::becauseOfNotFoundClassConstantReference($context, $classInfo, $node);
        }
        return $this->__invoke($reflectionConstant->getAst()->consts[$reflectionConstant->getPositionInAst()]->value, new \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext($context->getReflector(), $context->hasFileName() ? $context->getFileName() : null, $classInfo, $context->getNamespace(), $context->getFunctionName()));
    }
    /**
     * Compile a __DIR__ node
     */
    private function compileDirConstant(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $context) : string
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\FileHelper::normalizeWindowsPath(\dirname(\realpath($context->getFileName())));
    }
    /**
     * Compiles magic constant __CLASS__
     */
    private function compileClassConstant(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $context) : string
    {
        return $context->hasSelf() ? $context->getSelf()->getName() : '';
    }
    private function resolveClassNameForClassNameConstant(string $className, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $context) : string
    {
        if ($className === 'self' || $className === 'static') {
            return $context->getSelf()->getName();
        }
        if ($className === 'parent') {
            $parentClass = $context->getSelf()->getParentClass();
            \assert($parentClass instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass);
            return $parentClass->getName();
        }
        return $className;
    }
}
