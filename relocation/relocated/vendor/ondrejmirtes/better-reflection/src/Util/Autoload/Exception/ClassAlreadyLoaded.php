<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\Exception;

use LogicException;
use TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass;
use function sprintf;
final class ClassAlreadyLoaded extends \LogicException
{
    public static function fromReflectionClass(\TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Reflection\ReflectionClass $reflectionClass) : self
    {
        return new self(\sprintf('Class %s has already been loaded into memory so cannot be modified', $reflectionClass->getName()));
    }
}
