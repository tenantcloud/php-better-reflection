<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError81 implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\IdentifierRuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NonIgnorableRuleError
{
    public string $message;
    public string $identifier;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
}
