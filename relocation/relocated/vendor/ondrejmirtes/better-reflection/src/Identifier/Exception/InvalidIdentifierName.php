<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Identifier\Exception;

use InvalidArgumentException;
use function sprintf;
class InvalidIdentifierName extends \InvalidArgumentException
{
    public static function fromInvalidName(string $name) : self
    {
        return new self(\sprintf('Invalid identifier name "%s"', $name));
    }
}
