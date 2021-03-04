<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\BetterReflection\SourceLocator\Exception;

use LogicException;
class EvaledClosureCannotBeLocated extends \LogicException
{
    public static function create() : self
    {
        return new self('Evaled closure cannot be located');
    }
}
