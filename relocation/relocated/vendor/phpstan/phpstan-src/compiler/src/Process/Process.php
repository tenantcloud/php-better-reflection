<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process;

interface Process
{
    /**
     * @return \Symfony\Component\Process\Process<string, string>
     */
    public function getProcess() : \TenantCloud\BetterReflection\Relocated\Symfony\Component\Process\Process;
}
