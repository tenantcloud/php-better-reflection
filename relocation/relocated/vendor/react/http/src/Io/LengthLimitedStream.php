<?php

namespace TenantCloud\BetterReflection\Relocated\React\Http\Io;

use TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter;
use TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface;
use TenantCloud\BetterReflection\Relocated\React\Stream\Util;
use TenantCloud\BetterReflection\Relocated\React\Stream\WritableStreamInterface;
/**
 * [Internal] Limits the amount of data the given stream can emit
 *
 * This is used internally to limit the size of the underlying connection stream
 * to the size defined by the "Content-Length" header of the incoming request.
 *
 * @internal
 */
class LengthLimitedStream extends \TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter implements \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface
{
    private $stream;
    private $closed = \false;
    private $transferredLength = 0;
    private $maxLength;
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface $stream, $maxLength)
    {
        $this->stream = $stream;
        $this->maxLength = $maxLength;
        $this->stream->on('data', array($this, 'handleData'));
        $this->stream->on('end', array($this, 'handleEnd'));
        $this->stream->on('error', array($this, 'handleError'));
        $this->stream->on('close', array($this, 'close'));
    }
    public function isReadable()
    {
        return !$this->closed && $this->stream->isReadable();
    }
    public function pause()
    {
        $this->stream->pause();
    }
    public function resume()
    {
        $this->stream->resume();
    }
    public function pipe(\TenantCloud\BetterReflection\Relocated\React\Stream\WritableStreamInterface $dest, array $options = array())
    {
        \TenantCloud\BetterReflection\Relocated\React\Stream\Util::pipe($this, $dest, $options);
        return $dest;
    }
    public function close()
    {
        if ($this->closed) {
            return;
        }
        $this->closed = \true;
        $this->stream->close();
        $this->emit('close');
        $this->removeAllListeners();
    }
    /** @internal */
    public function handleData($data)
    {
        if ($this->transferredLength + \strlen($data) > $this->maxLength) {
            // Only emit data until the value of 'Content-Length' is reached, the rest will be ignored
            $data = (string) \substr($data, 0, $this->maxLength - $this->transferredLength);
        }
        if ($data !== '') {
            $this->transferredLength += \strlen($data);
            $this->emit('data', array($data));
        }
        if ($this->transferredLength === $this->maxLength) {
            // 'Content-Length' reached, stream will end
            $this->emit('end');
            $this->close();
            $this->stream->removeListener('data', array($this, 'handleData'));
        }
    }
    /** @internal */
    public function handleError(\Exception $e)
    {
        $this->emit('error', array($e));
        $this->close();
    }
    /** @internal */
    public function handleEnd()
    {
        if (!$this->closed) {
            $this->handleError(new \Exception('Unexpected end event'));
        }
    }
}
