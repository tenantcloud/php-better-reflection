<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

interface IdentifierRuleError extends \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
{
    public function getIdentifier() : string;
}
