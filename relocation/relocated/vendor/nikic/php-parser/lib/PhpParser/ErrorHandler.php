<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PhpParser;

interface ErrorHandler
{
    /**
     * Handle an error generated during lexing, parsing or some other operation.
     *
     * @param Error $error The error that needs to be handled
     */
    public function handleError(\TenantCloud\BetterReflection\Relocated\PhpParser\Error $error);
}
