<?php

namespace TenantCloud\BetterReflection\Relocated\React\Http\Io;

use TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter;
use TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface;
use TenantCloud\BetterReflection\Relocated\React\Stream\Util;
use TenantCloud\BetterReflection\Relocated\React\Stream\WritableStreamInterface;
/**
 * [Internal] Protects a given stream from actually closing and only discards its incoming data instead.
 *
 * This is used internally to prevent the underlying connection from closing, so
 * that we can still send back a response over the same stream.
 *
 * @internal
 * */
class CloseProtectionStream extends \TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter implements \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface
{
    private $input;
    private $closed = \false;
    private $paused = \false;
    /**
     * @param ReadableStreamInterface $input stream that will be discarded instead of closing it on an 'close' event.
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface $input)
    {
        $this->input = $input;
        $this->input->on('data', array($this, 'handleData'));
        $this->input->on('end', array($this, 'handleEnd'));
        $this->input->on('error', array($this, 'handleError'));
        $this->input->on('close', array($this, 'close'));
    }
    public function isReadable()
    {
        return !$this->closed && $this->input->isReadable();
    }
    public function pause()
    {
        if ($this->closed) {
            return;
        }
        $this->paused = \true;
        $this->input->pause();
    }
    public function resume()
    {
        if ($this->closed) {
            return;
        }
        $this->paused = \false;
        $this->input->resume();
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
        // stop listening for incoming events
        $this->input->removeListener('data', array($this, 'handleData'));
        $this->input->removeListener('error', array($this, 'handleError'));
        $this->input->removeListener('end', array($this, 'handleEnd'));
        $this->input->removeListener('close', array($this, 'close'));
        // resume the stream to ensure we discard everything from incoming connection
        if ($this->paused) {
            $this->paused = \false;
            $this->input->resume();
        }
        $this->emit('close');
        $this->removeAllListeners();
    }
    /** @internal */
    public function handleData($data)
    {
        $this->emit('data', array($data));
    }
    /** @internal */
    public function handleEnd()
    {
        $this->emit('end');
        $this->close();
    }
    /** @internal */
    public function handleError(\Exception $e)
    {
        $this->emit('error', array($e));
    }
}
