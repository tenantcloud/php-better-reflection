<?php

namespace TenantCloud\BetterReflection\Relocated\React\Http\Client;

use TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface;
use TenantCloud\BetterReflection\Relocated\React\Socket\ConnectorInterface;
use TenantCloud\BetterReflection\Relocated\React\Socket\Connector;
/**
 * @internal
 */
class Client
{
    private $connector;
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop, \TenantCloud\BetterReflection\Relocated\React\Socket\ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new \TenantCloud\BetterReflection\Relocated\React\Socket\Connector($loop);
        }
        $this->connector = $connector;
    }
    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0')
    {
        $requestData = new \TenantCloud\BetterReflection\Relocated\React\Http\Client\RequestData($method, $url, $headers, $protocolVersion);
        return new \TenantCloud\BetterReflection\Relocated\React\Http\Client\Request($this->connector, $requestData);
    }
}
