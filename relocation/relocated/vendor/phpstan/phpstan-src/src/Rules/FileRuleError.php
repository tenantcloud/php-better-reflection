<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules;

interface FileRuleError extends \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
{
    public function getFile() : string;
}
