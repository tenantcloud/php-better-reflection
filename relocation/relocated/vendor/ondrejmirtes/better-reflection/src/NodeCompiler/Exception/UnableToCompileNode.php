<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\Exception;

use LogicException;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use function assert;
use function get_class;
use function sprintf;
class UnableToCompileNode extends \LogicException
{
    /** @var string|null */
    private $constantName;
    public function constantName() : ?string
    {
        return $this->constantName;
    }
    public static function forUnRecognizedExpressionInContext(\TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr $expression, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $context) : self
    {
        return new self(\sprintf('Unable to compile expression in %s: unrecognized node type %s at line %d', self::compilerContextToContextDescription($context), \get_class($expression), $expression->getLine()));
    }
    public static function becauseOfNotFoundClassConstantReference(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $fetchContext, \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $targetClass, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ClassConstFetch $constantFetch) : self
    {
        \assert($constantFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier);
        return new self(\sprintf('Could not locate constant %s::%s while trying to evaluate constant expression in %s at line %s', $targetClass->getName(), $constantFetch->name->name, self::compilerContextToContextDescription($fetchContext), $constantFetch->getLine()));
    }
    public static function becauseOfNotFoundConstantReference(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $fetchContext, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\ConstFetch $constantFetch) : self
    {
        $constantName = $constantFetch->name->toString();
        $exception = new self(\sprintf('Could not locate constant "%s" while evaluating expression in %s at line %s', $constantName, self::compilerContextToContextDescription($fetchContext), $constantFetch->getLine()));
        $exception->constantName = $constantName;
        return $exception;
    }
    private static function compilerContextToContextDescription(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\NodeCompiler\CompilerContext $fetchContext) : string
    {
        // @todo improve in https://github.com/Roave/BetterReflection/issues/434
        return $fetchContext->hasSelf() ? $fetchContext->getSelf()->getName() : 'unknown context (probably a function)';
    }
}
