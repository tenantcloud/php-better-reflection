<?php

namespace TenantCloud\BetterReflection\Relocated\React\Http\Io;

use TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter;
use TenantCloud\BetterReflection\Relocated\Psr\Http\Message\StreamInterface;
use TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface;
use TenantCloud\BetterReflection\Relocated\React\Stream\Util;
use TenantCloud\BetterReflection\Relocated\React\Stream\WritableStreamInterface;
/**
 * [Internal] Bridge between an empty StreamInterface from PSR-7 and ReadableStreamInterface from ReactPHP
 *
 * This class is used in the server to represent an empty body stream of an
 * incoming response from the client. This is similar to the `HttpBodyStream`,
 * but is specifically designed for the common case of having an empty message
 * body.
 *
 * Note that this is an internal class only and nothing you should usually care
 * about. See the `StreamInterface` and `ReadableStreamInterface` for more
 * details.
 *
 * @see HttpBodyStream
 * @see StreamInterface
 * @see ReadableStreamInterface
 * @internal
 */
class EmptyBodyStream extends \TenantCloud\BetterReflection\Relocated\Evenement\EventEmitter implements \TenantCloud\BetterReflection\Relocated\Psr\Http\Message\StreamInterface, \TenantCloud\BetterReflection\Relocated\React\Stream\ReadableStreamInterface
{
    private $closed = \false;
    public function isReadable()
    {
        return !$this->closed;
    }
    public function pause()
    {
        // NOOP
    }
    public function resume()
    {
        // NOOP
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
        $this->emit('close');
        $this->removeAllListeners();
    }
    public function getSize()
    {
        return 0;
    }
    /** @ignore */
    public function __toString()
    {
        return '';
    }
    /** @ignore */
    public function detach()
    {
        return null;
    }
    /** @ignore */
    public function tell()
    {
        throw new \BadMethodCallException();
    }
    /** @ignore */
    public function eof()
    {
        throw new \BadMethodCallException();
    }
    /** @ignore */
    public function isSeekable()
    {
        return \false;
    }
    /** @ignore */
    public function seek($offset, $whence = \SEEK_SET)
    {
        throw new \BadMethodCallException();
    }
    /** @ignore */
    public function rewind()
    {
        throw new \BadMethodCallException();
    }
    /** @ignore */
    public function isWritable()
    {
        return \false;
    }
    /** @ignore */
    public function write($string)
    {
        throw new \BadMethodCallException();
    }
    /** @ignore */
    public function read($length)
    {
        throw new \BadMethodCallException();
    }
    /** @ignore */
    public function getContents()
    {
        return '';
    }
    /** @ignore */
    public function getMetadata($key = null)
    {
        return $key === null ? array() : null;
    }
}
