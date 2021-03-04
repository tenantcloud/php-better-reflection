<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception;

use InvalidArgumentException;
use function sprintf;
class ObjectNotInstanceOfClass extends \InvalidArgumentException
{
    public static function fromClassName(string $className) : self
    {
        return new self(\sprintf('Object is not instance of class "%s"', $className));
    }
}
