<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Process\Runnable;

interface RunnableQueueLogger
{
    public function log(string $message) : void;
}
