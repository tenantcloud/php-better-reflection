<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Exception;

use InvalidArgumentException;
use function sprintf;
class InvalidNodePosition extends \InvalidArgumentException
{
    public static function fromPosition(int $position) : self
    {
        return new self(\sprintf('Invalid position %d', $position));
    }
}
