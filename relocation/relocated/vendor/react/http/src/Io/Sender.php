<?php

namespace TenantCloud\BetterReflection\Relocated\React\Http\Io;

use TenantCloud\BetterReflection\Relocated\Psr\Http\Message\RequestInterface;
use TenantCloud\BetterReflection\Relocated\Psr\Http\Message\ResponseInterface;
use TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface;
use TenantCloud\BetterReflection\Relocated\React\Http\Client\Client as HttpClient;
use TenantCloud\BetterReflection\Relocated\React\Promise\PromiseInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise\Deferred;
use TenantCloud\BetterReflection\Relocated\React\Socket\ConnectorInterface;
use TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface;
/**
 * [Internal] Sends requests and receives responses
 *
 * The `Sender` is responsible for passing the [`RequestInterface`](#requestinterface) objects to
 * the underlying [`HttpClient`](https://github.com/reactphp/http-client) library
 * and keeps track of its transmission and converts its reponses back to [`ResponseInterface`](#responseinterface) objects.
 *
 * It also registers everything with the main [`EventLoop`](https://github.com/reactphp/event-loop#usage)
 * and the default [`Connector`](https://github.com/reactphp/socket-client) and [DNS `Resolver`](https://github.com/reactphp/dns).
 *
 * The `Sender` class mostly exists in order to abstract changes on the underlying
 * components away from this package in order to provide backwards and forwards
 * compatibility.
 *
 * @internal You SHOULD NOT rely on this API, it is subject to change without prior notice!
 * @see Browser
 */
class Sender
{
    /**
     * create a new default sender attached to the given event loop
     *
     * This method is used internally to create the "default sender".
     *
     * You may also use this method if you need custom DNS or connector
     * settings. You can use this method manually like this:
     *
     * ```php
     * $connector = new \React\Socket\Connector($loop);
     * $sender = \React\Http\Io\Sender::createFromLoop($loop, $connector);
     * ```
     *
     * @param LoopInterface $loop
     * @param ConnectorInterface|null $connector
     * @return self
     */
    public static function createFromLoop(\TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop, \TenantCloud\BetterReflection\Relocated\React\Socket\ConnectorInterface $connector = null)
    {
        return new self(new \TenantCloud\BetterReflection\Relocated\React\Http\Client\Client($loop, $connector));
    }
    private $http;
    /**
     * [internal] Instantiate Sender
     *
     * @param HttpClient $http
     * @internal
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\Http\Client\Client $http)
    {
        $this->http = $http;
    }
    /**
     *
     * @internal
     * @param RequestInterface $request
     * @return PromiseInterface Promise<ResponseInterface, Exception>
     */
    public function send(\TenantCloud\BetterReflection\Relocated\Psr\Http\Message\RequestInterface $request)
    {
        $body = $request->getBody();
        $size = $body->getSize();
        if ($size !== null && $size !== 0) {
            // automatically assign a "Content-Length" request header if the body size is known and non-empty
            $request = $request->withHeader('Content-Length', (string) $size);
        } elseif ($size === 0 && \in_array($request->getMethod(), array('POST', 'PUT', 'PATCH'))) {
            // only assign a "Content-Length: 0" request header if the body is expected for certain methods
            $request = $request->withHeader('Content-Length', '0');
        } elseif ($body instanceof \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface && $body->isReadable() && !$request->hasHeader('Content-Length')) {
            // use "Transfer-Encoding: chunked" when this is a streaming body and body size is unknown
            $request = $request->withHeader('Transfer-Encoding', 'chunked');
        } else {
            // do not use chunked encoding if size is known or if this is an empty request body
            $size = 0;
        }
        $headers = array();
        foreach ($request->getHeaders() as $name => $values) {
            $headers[$name] = \implode(', ', $values);
        }
        $requestStream = $this->http->request($request->getMethod(), (string) $request->getUri(), $headers, $request->getProtocolVersion());
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred(function ($_, $reject) use($requestStream) {
            // close request stream if request is cancelled
            $reject(new \RuntimeException('Request cancelled'));
            $requestStream->close();
        });
        $requestStream->on('error', function ($error) use($deferred) {
            $deferred->reject($error);
        });
        $requestStream->on('response', function (\TenantCloud\BetterReflection\Relocated\Psr\Http\Message\ResponseInterface $response, \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface $body) use($deferred, $request) {
            $length = null;
            $code = $response->getStatusCode();
            if ($request->getMethod() === 'HEAD' || $code >= 100 && $code < 200 || $code == 204 || $code == 304) {
                $length = 0;
            } elseif (\strtolower($response->getHeaderLine('Transfer-Encoding')) === 'chunked') {
                $body = new \TenantCloud\BetterReflection\Relocated\React\Http\Io\ChunkedDecoder($body);
            } elseif ($response->hasHeader('Content-Length')) {
                $length = (int) $response->getHeaderLine('Content-Length');
            }
            $deferred->resolve($response->withBody(new \TenantCloud\BetterReflection\Relocated\React\Http\Io\ReadableBodyStream($body, $length)));
        });
        if ($body instanceof \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface) {
            if ($body->isReadable()) {
                // length unknown => apply chunked transfer-encoding
                if ($size === null) {
                    $body = new \TenantCloud\BetterReflection\Relocated\React\Http\Io\ChunkedEncoder($body);
                }
                // pipe body into request stream
                // add dummy write to immediately start request even if body does not emit any data yet
                $body->pipe($requestStream);
                $requestStream->write('');
                $body->on('close', $close = function () use($deferred, $requestStream) {
                    $deferred->reject(new \RuntimeException('Request failed because request body closed unexpectedly'));
                    $requestStream->close();
                });
                $body->on('error', function ($e) use($deferred, $requestStream, $close, $body) {
                    $body->removeListener('close', $close);
                    $deferred->reject(new \RuntimeException('Request failed because request body reported an error', 0, $e));
                    $requestStream->close();
                });
                $body->on('end', function () use($close, $body) {
                    $body->removeListener('close', $close);
                });
            } else {
                // stream is not readable => end request without body
                $requestStream->end();
            }
        } else {
            // body is fully buffered => write as one chunk
            $requestStream->end((string) $body);
        }
        return $deferred->promise();
    }
}
