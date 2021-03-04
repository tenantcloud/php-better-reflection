<?php

namespace TenantCloud\BetterReflection\Relocated\React\Dns\Resolver;

use TenantCloud\BetterReflection\Relocated\React\Cache\ArrayCache;
use TenantCloud\BetterReflection\Relocated\React\Cache\CacheInterface;
use TenantCloud\BetterReflection\Relocated\React\Dns\Config\HostsFile;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\CachingExecutor;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\CoopExecutor;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\ExecutorInterface;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\HostsFileExecutor;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\RetryExecutor;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\SelectiveTransportExecutor;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\TcpTransportExecutor;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\TimeoutExecutor;
use TenantCloud\BetterReflection\Relocated\React\Dns\Query\UdpTransportExecutor;
use TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface;
final class Factory
{
    /**
     * @param string        $nameserver
     * @param LoopInterface $loop
     * @return \React\Dns\Resolver\ResolverInterface
     */
    public function create($nameserver, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
    {
        $executor = $this->decorateHostsFileExecutor($this->createExecutor($nameserver, $loop));
        return new \TenantCloud\BetterReflection\Relocated\React\Dns\Resolver\Resolver($executor);
    }
    /**
     * @param string          $nameserver
     * @param LoopInterface   $loop
     * @param ?CacheInterface $cache
     * @return \React\Dns\Resolver\ResolverInterface
     */
    public function createCached($nameserver, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop, \TenantCloud\BetterReflection\Relocated\React\Cache\CacheInterface $cache = null)
    {
        // default to keeping maximum of 256 responses in cache unless explicitly given
        if (!$cache instanceof \TenantCloud\BetterReflection\Relocated\React\Cache\CacheInterface) {
            $cache = new \TenantCloud\BetterReflection\Relocated\React\Cache\ArrayCache(256);
        }
        $executor = $this->createExecutor($nameserver, $loop);
        $executor = new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\CachingExecutor($executor, $cache);
        $executor = $this->decorateHostsFileExecutor($executor);
        return new \TenantCloud\BetterReflection\Relocated\React\Dns\Resolver\Resolver($executor);
    }
    /**
     * Tries to load the hosts file and decorates the given executor on success
     *
     * @param ExecutorInterface $executor
     * @return ExecutorInterface
     * @codeCoverageIgnore
     */
    private function decorateHostsFileExecutor(\TenantCloud\BetterReflection\Relocated\React\Dns\Query\ExecutorInterface $executor)
    {
        try {
            $executor = new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\HostsFileExecutor(\TenantCloud\BetterReflection\Relocated\React\Dns\Config\HostsFile::loadFromPathBlocking(), $executor);
        } catch (\RuntimeException $e) {
            // ignore this file if it can not be loaded
        }
        // Windows does not store localhost in hosts file by default but handles this internally
        // To compensate for this, we explicitly use hard-coded defaults for localhost
        if (\DIRECTORY_SEPARATOR === '\\') {
            $executor = new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\HostsFileExecutor(new \TenantCloud\BetterReflection\Relocated\React\Dns\Config\HostsFile("127.0.0.1 localhost\n::1 localhost"), $executor);
        }
        return $executor;
    }
    private function createExecutor($nameserver, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
    {
        $parts = \parse_url($nameserver);
        if (isset($parts['scheme']) && $parts['scheme'] === 'tcp') {
            $executor = $this->createTcpExecutor($nameserver, $loop);
        } elseif (isset($parts['scheme']) && $parts['scheme'] === 'udp') {
            $executor = $this->createUdpExecutor($nameserver, $loop);
        } else {
            $executor = new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\SelectiveTransportExecutor($this->createUdpExecutor($nameserver, $loop), $this->createTcpExecutor($nameserver, $loop));
        }
        return new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\CoopExecutor($executor);
    }
    private function createTcpExecutor($nameserver, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
    {
        return new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\TimeoutExecutor(new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\TcpTransportExecutor($nameserver, $loop), 5.0, $loop);
    }
    private function createUdpExecutor($nameserver, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
    {
        return new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\RetryExecutor(new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\TimeoutExecutor(new \TenantCloud\BetterReflection\Relocated\React\Dns\Query\UdpTransportExecutor($nameserver, $loop), 5.0, $loop));
    }
}
