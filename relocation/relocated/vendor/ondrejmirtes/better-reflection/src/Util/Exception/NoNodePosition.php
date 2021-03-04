<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Exception;

use InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\PhpParser\Lexer;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use function get_class;
use function sprintf;
class NoNodePosition extends \InvalidArgumentException
{
    public static function fromNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node) : self
    {
        return new self(\sprintf('%s doesn\'t contain position. Your %s is not configured properly', \get_class($node), \TenantCloud\BetterReflection\Relocated\PhpParser\Lexer::class));
    }
}
