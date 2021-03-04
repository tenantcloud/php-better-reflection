<?php

namespace TenantCloud\BetterReflection\Relocated\React\Socket;

use TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise;
use InvalidArgumentException;
use RuntimeException;
/**
 * Unix domain socket connector
 *
 * Unix domain sockets use atomic operations, so we can as well emulate
 * async behavior.
 */
final class UnixConnector implements \TenantCloud\BetterReflection\Relocated\React\Socket\ConnectorInterface
{
    private $loop;
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
    {
        $this->loop = $loop;
    }
    public function connect($path)
    {
        if (\strpos($path, '://') === \false) {
            $path = 'unix://' . $path;
        } elseif (\substr($path, 0, 7) !== 'unix://') {
            return \TenantCloud\BetterReflection\Relocated\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $path . '" is invalid'));
        }
        $resource = @\stream_socket_client($path, $errno, $errstr, 1.0);
        if (!$resource) {
            return \TenantCloud\BetterReflection\Relocated\React\Promise\reject(new \RuntimeException('Unable to connect to unix domain socket "' . $path . '": ' . $errstr, $errno));
        }
        $connection = new \TenantCloud\BetterReflection\Relocated\React\Socket\Connection($resource, $this->loop);
        $connection->unix = \true;
        return \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($connection);
    }
}
