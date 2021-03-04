<?php

namespace TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream;

use TenantCloud\BetterReflection\Relocated\React\Promise\Stream;
use TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream;
class AllTest extends \TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream\TestCase
{
    public function testClosedStreamResolvesWithEmptyBuffer()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $stream->close();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $this->expectPromiseResolveWith(array(), $promise);
    }
    public function testClosedWritableStreamResolvesWithEmptyBuffer()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $stream->close();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $this->expectPromiseResolveWith(array(), $promise);
    }
    public function testPendingStreamWillNotResolve()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $promise->then($this->expectCallableNever(), $this->expectCallableNever());
    }
    public function testClosingStreamResolvesWithEmptyBuffer()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $stream->close();
        $this->expectPromiseResolveWith(array(), $promise);
    }
    public function testClosingWritableStreamResolvesWithEmptyBuffer()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $stream->close();
        $this->expectPromiseResolveWith(array(), $promise);
    }
    public function testEmittingDataOnStreamResolvesWithArrayOfData()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('data', array('world', $stream));
        $stream->close();
        $this->expectPromiseResolveWith(array('hello', 'world'), $promise);
    }
    public function testEmittingCustomEventOnStreamResolvesWithArrayOfCustomEventData()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream, 'a');
        $stream->emit('a', array('hello'));
        $stream->emit('b', array('ignored'));
        $stream->emit('a');
        $stream->close();
        $this->expectPromiseResolveWith(array('hello', null), $promise);
    }
    public function testEmittingErrorOnStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testEmittingErrorAfterEmittingDataOnStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testCancelPendingStreamWillReject()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\all($stream);
        $promise->cancel();
        $this->expectPromiseReject($promise);
    }
}
