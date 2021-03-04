<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

interface RuleError
{
    public function getMessage() : string;
}
