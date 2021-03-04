<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\Exception;

use LogicException;
class Uncloneable extends \LogicException
{
    public static function fromClass(string $className) : self
    {
        return new self('Trying to clone an uncloneable object of class ' . $className);
    }
}
