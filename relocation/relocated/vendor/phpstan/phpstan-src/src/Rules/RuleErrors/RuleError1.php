<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError1 implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError
{
    public string $message;
    public function getMessage() : string
    {
        return $this->message;
    }
}
