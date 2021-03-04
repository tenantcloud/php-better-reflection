<?php

namespace TenantCloud\BetterReflection\Relocated\React\Dns\Query;

use TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise\Timer;
final class TimeoutExecutor implements \TenantCloud\BetterReflection\Relocated\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\Dns\Query\ExecutorInterface $executor, $timeout, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
    {
        $this->executor = $executor;
        $this->loop = $loop;
        $this->timeout = $timeout;
    }
    public function query(\TenantCloud\BetterReflection\Relocated\React\Dns\Query\Query $query)
    {
        return \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\TimeoutException) {
                $e = new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->name), 0, $e);
            }
            throw $e;
        });
    }
}
