<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleErrors;

/**
 * @internal Use PHPStan\Rules\RuleErrorBuilder instead.
 */
class RuleError111 implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\RuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\LineRuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\FileRuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\TipRuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\MetadataRuleError, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\NonIgnorableRuleError
{
    public string $message;
    public int $line;
    public string $file;
    public string $tip;
    /** @var mixed[] */
    public array $metadata;
    public function getMessage() : string
    {
        return $this->message;
    }
    public function getLine() : int
    {
        return $this->line;
    }
    public function getFile() : string
    {
        return $this->file;
    }
    public function getTip() : string
    {
        return $this->tip;
    }
    /**
     * @return mixed[]
     */
    public function getMetadata() : array
    {
        return $this->metadata;
    }
}
