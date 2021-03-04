<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

interface TipRuleError extends \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
{
    public function getTip() : string;
}
