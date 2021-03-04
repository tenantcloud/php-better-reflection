<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\SourceStubber\Exception;

use RuntimeException;
class CouldNotFindPhpStormStubs extends \RuntimeException
{
    public static function create() : self
    {
        return new self('Could not find PhpStorm stubs');
    }
}
