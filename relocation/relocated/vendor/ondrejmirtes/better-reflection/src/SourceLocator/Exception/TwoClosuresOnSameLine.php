<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception;

use LogicException;
use function sprintf;
class TwoClosuresOnSameLine extends \LogicException
{
    public static function create(string $fileName, int $lineNumber) : self
    {
        return new self(\sprintf('Two closures on line %d in %s', $lineNumber, $fileName));
    }
}
