<?php

namespace TenantCloud\BetterReflection\Relocated\React\Http\Middleware;

use OverflowException;
use TenantCloud\BetterReflection\Relocated\Psr\Http\Message\ServerRequestInterface;
use TenantCloud\BetterReflection\Relocated\React\Http\Io\BufferedBody;
use TenantCloud\BetterReflection\Relocated\React\Http\Io\IniUtil;
use TenantCloud\BetterReflection\Relocated\React\Promise\Stream;
use TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface;
final class RequestBodyBufferMiddleware
{
    private $sizeLimit;
    /**
     * @param int|string|null $sizeLimit Either an int with the max request body size
     *                                   in bytes or an ini like size string
     *                                   or null to use post_max_size from PHP's
     *                                   configuration. (Note that the value from
     *                                   the CLI configuration will be used.)
     */
    public function __construct($sizeLimit = null)
    {
        if ($sizeLimit === null) {
            $sizeLimit = \ini_get('post_max_size');
        }
        $this->sizeLimit = \TenantCloud\BetterReflection\Relocated\React\Http\Io\IniUtil::iniSizeToBytes($sizeLimit);
    }
    public function __invoke(\TenantCloud\BetterReflection\Relocated\Psr\Http\Message\ServerRequestInterface $request, $stack)
    {
        $body = $request->getBody();
        $size = $body->getSize();
        // happy path: skip if body is known to be empty (or is already buffered)
        if ($size === 0 || !$body instanceof \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface) {
            // replace with empty body if body is streaming (or buffered size exceeds limit)
            if ($body instanceof \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface || $size > $this->sizeLimit) {
                $request = $request->withBody(new \TenantCloud\BetterReflection\Relocated\React\Http\Io\BufferedBody(''));
            }
            return $stack($request);
        }
        // request body of known size exceeding limit
        $sizeLimit = $this->sizeLimit;
        if ($size > $this->sizeLimit) {
            $sizeLimit = 0;
        }
        return \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($body, $sizeLimit)->then(function ($buffer) use($request, $stack) {
            $request = $request->withBody(new \TenantCloud\BetterReflection\Relocated\React\Http\Io\BufferedBody($buffer));
            return $stack($request);
        }, function ($error) use($stack, $request, $body) {
            // On buffer overflow keep the request body stream in,
            // but ignore the contents and wait for the close event
            // before passing the request on to the next middleware.
            if ($error instanceof \OverflowException) {
                return \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($body, 'close')->then(function () use($stack, $request) {
                    return $stack($request);
                });
            }
            throw $error;
        });
    }
}
