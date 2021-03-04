<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception;

use InvalidArgumentException;
use function sprintf;
final class InvalidProjectDirectory extends \InvalidArgumentException implements \TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Type\Composer\Factory\Exception\Exception
{
    public static function atPath(string $path) : self
    {
        return new self(\sprintf('Could not locate project directory "%s"', $path));
    }
}
