<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
interface ProcessFactory
{
    /**
     * @param string[] $command
     * @param string $cwd
     * @return \PHPStan\Compiler\Process\Process
     */
    public function create(array $command, string $cwd) : \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\Process;
    public function setOutput(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) : void;
}
