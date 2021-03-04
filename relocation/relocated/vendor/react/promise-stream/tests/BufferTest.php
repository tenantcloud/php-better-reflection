<?php

namespace TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream;

use TenantCloud\BetterReflection\Relocated\Clue\React\Block;
use TenantCloud\BetterReflection\Relocated\React\EventLoop\Factory;
use TenantCloud\BetterReflection\Relocated\React\Promise\Stream;
use TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream;
class BufferTest extends \TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream\TestCase
{
    public function testClosedStreamResolvesWithEmptyBuffer()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $stream->close();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream);
        $this->expectPromiseResolveWith('', $promise);
    }
    public function testPendingStreamWillNotResolve()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream);
        $promise->then($this->expectCallableNever(), $this->expectCallableNever());
    }
    public function testClosingStreamResolvesWithEmptyBuffer()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream);
        $stream->close();
        $this->expectPromiseResolveWith('', $promise);
    }
    public function testEmittingDataOnStreamResolvesWithConcatenatedData()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('data', array('world', $stream));
        $stream->close();
        $this->expectPromiseResolveWith('helloworld', $promise);
    }
    public function testEmittingErrorOnStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream);
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testEmittingErrorAfterEmittingDataOnStreamRejects()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testCancelPendingStreamWillReject()
    {
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream);
        $promise->cancel();
        $this->expectPromiseReject($promise);
    }
    public function testMaximumSize()
    {
        $loop = \TenantCloud\BetterReflection\Relocated\React\EventLoop\Factory::create();
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $loop->addTimer(0.1, function () use($stream) {
            $stream->write('12345678910111213141516');
        });
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream, 16);
        if (\method_exists($this, 'expectException')) {
            $this->expectException('OverflowException');
            $this->expectExceptionMessage('Buffer exceeded maximum length');
        } else {
            $this->setExpectedException('\\OverflowException', 'Buffer exceeded maximum length');
        }
        \TenantCloud\BetterReflection\Relocated\Clue\React\Block\await($promise, $loop, 10);
    }
    public function testUnderMaximumSize()
    {
        $loop = \TenantCloud\BetterReflection\Relocated\React\EventLoop\Factory::create();
        $stream = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $loop->addTimer(0.1, function () use($stream) {
            $stream->write('1234567891011');
            $stream->end();
        });
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($stream, 16);
        $result = \TenantCloud\BetterReflection\Relocated\Clue\React\Block\await($promise, $loop, 10);
        $this->assertSame('1234567891011', $result);
    }
}
