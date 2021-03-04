<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception;

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunctionAbstract;
use function get_class;
use function sprintf;
class InvalidAbstractFunctionNodeType extends \InvalidArgumentException
{
    public static function fromNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : self
    {
        return new self(\sprintf('Node for "%s" must be "%s" or "%s", was a "%s"', \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionFunctionAbstract::class, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\ClassMethod::class, \TenantCloud\BetterReflection\Relocated\PhpParser\Node\FunctionLike::class, \get_class($node)));
    }
}
