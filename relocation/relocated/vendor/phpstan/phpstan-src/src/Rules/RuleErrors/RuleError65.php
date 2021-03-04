<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError65 implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NonIgnorableRuleError
{
    public string $message;
    public function getMessage() : string
    {
        return $this->message;
    }
}
