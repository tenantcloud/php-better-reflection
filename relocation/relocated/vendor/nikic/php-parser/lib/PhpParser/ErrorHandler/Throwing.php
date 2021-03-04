<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler;

use TenantCloud\BetterReflection\Relocated\PhpParser\Error;
use TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements \TenantCloud\BetterReflection\Relocated\PhpParser\ErrorHandler
{
    public function handleError(\TenantCloud\BetterReflection\Relocated\PhpParser\Error $error)
    {
        throw $error;
    }
}
