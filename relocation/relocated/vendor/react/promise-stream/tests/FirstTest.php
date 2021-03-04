<?php

namespace TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream;

use TenantCloud\BetterReflection\Relocated\React\Promise\Stream;
use TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream;
class FirstTest extends \TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream\TestCase
{
    public function testClosedReadableStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $stream->close();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $this->expectPromiseReject($promise);
    }
    public function testClosedWritableStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $stream->close();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $this->expectPromiseReject($promise);
    }
    public function testPendingStreamWillNotResolve()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $promise->then($this->expectCallableNever(), $this->expectCallableNever());
    }
    public function testClosingStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $stream->close();
        $this->expectPromiseReject($promise);
    }
    public function testClosingWritableStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $stream->close();
        $this->expectPromiseReject($promise);
    }
    public function testClosingStreamResolvesWhenWaitingForCloseEvent()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream, 'close');
        $stream->close();
        $this->expectPromiseResolve($promise);
    }
    public function testEmittingDataOnStreamResolvesWithFirstEvent()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('data', array('world', $stream));
        $stream->close();
        $this->expectPromiseResolveWith('hello', $promise);
    }
    public function testEmittingErrorOnStreamWillReject()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testEmittingErrorResolvesWhenWaitingForErrorEvent()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream, 'error');
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseResolve($promise);
    }
    public function testCancelPendingStreamWillReject()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\first($stream);
        $promise->cancel();
        $this->expectPromiseReject($promise);
    }
}
