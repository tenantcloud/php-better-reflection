<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

interface LineRuleError extends \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
{
    public function getLine() : int;
}
