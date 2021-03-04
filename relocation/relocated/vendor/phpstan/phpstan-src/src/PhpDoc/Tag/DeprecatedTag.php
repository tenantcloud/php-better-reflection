<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag;

class DeprecatedTag
{
    private ?string $message;
    public function __construct(?string $message)
    {
        $this->message = $message;
    }
    public function getMessage() : ?string
    {
        return $this->message;
    }
}
