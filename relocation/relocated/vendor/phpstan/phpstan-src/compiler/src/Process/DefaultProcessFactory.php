<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
final class DefaultProcessFactory implements \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\ProcessFactory
{
    /** @var OutputInterface */
    private $output;
    public function __construct()
    {
        $this->output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\NullOutput();
    }
    /**
     * @param string[] $command
     * @param string $cwd
     * @return \PHPStan\Compiler\Process\Process
     */
    public function create(array $command, string $cwd) : \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\Process
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\SymfonyProcess($command, $cwd, $this->output);
    }
    public function setOutput(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $this->output = $output;
    }
}
