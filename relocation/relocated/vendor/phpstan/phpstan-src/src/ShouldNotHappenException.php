<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan;

final class ShouldNotHappenException extends \Exception
{
    public function __construct(string $message = 'Internal error.')
    {
        parent::__construct($message);
    }
}
