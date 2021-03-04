<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Parallel;

use TenantCloud\BetterReflection\Relocated\React\Socket\TcpServer;
use function array_key_exists;
class ProcessPool
{
    private \TenantCloud\BetterReflection\Relocated\React\Socket\TcpServer $server;
    /** @var array<string, Process> */
    private array $processes = [];
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\Socket\TcpServer $server)
    {
        $this->server = $server;
    }
    public function getProcess(string $identifier) : \TenantCloud\BetterReflection\Relocated\PHPStan\Parallel\Process
    {
        if (!\array_key_exists($identifier, $this->processes)) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException(\sprintf('Process %s not found.', $identifier));
        }
        return $this->processes[$identifier];
    }
    public function attachProcess(string $identifier, \TenantCloud\BetterReflection\Relocated\PHPStan\Parallel\Process $process) : void
    {
        $this->processes[$identifier] = $process;
    }
    public function tryQuitProcess(string $identifier) : void
    {
        if (!\array_key_exists($identifier, $this->processes)) {
            return;
        }
        $this->quitProcess($identifier);
    }
    private function quitProcess(string $identifier) : void
    {
        $process = $this->getProcess($identifier);
        $process->quit();
        unset($this->processes[$identifier]);
        if (\count($this->processes) !== 0) {
            return;
        }
        $this->server->close();
    }
    public function quitAll() : void
    {
        foreach (\array_keys($this->processes) as $identifier) {
            $this->quitProcess($identifier);
        }
    }
}
