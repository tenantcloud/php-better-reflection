<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\Util\Autoload\Exception;

use LogicException;
use function sprintf;
final class FailedToLoadClass extends \LogicException
{
    public static function fromClassName(string $className) : self
    {
        return new self(\sprintf('Unable to load class %s', $className));
    }
}
