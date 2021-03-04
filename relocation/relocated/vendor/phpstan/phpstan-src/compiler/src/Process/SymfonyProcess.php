<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
final class SymfonyProcess implements \TenantCloud\BetterReflection\Relocated\PHPStan\Compiler\Process\Process
{
    /** @var \Symfony\Component\Process\Process<string, string> */
    private $process;
    /**
     * @param string[] $command
     * @param string $cwd
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(array $command, string $cwd, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->process = (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Process\Process($command, $cwd, null, null, null))->mustRun(static function (string $type, string $buffer) use($output) : void {
            $output->write($buffer);
        });
    }
    /**
     * @return \Symfony\Component\Process\Process<string, string>
     */
    public function getProcess() : \TenantCloud\BetterReflection\Relocated\Symfony\Component\Process\Process
    {
        return $this->process;
    }
}
