<?php

namespace TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream;

use TenantCloud\BetterReflection\Relocated\Clue\React\Block;
use TenantCloud\BetterReflection\Relocated\React\EventLoop\Factory;
use TenantCloud\BetterReflection\Relocated\React\Promise;
use TenantCloud\BetterReflection\Relocated\React\Promise\Stream;
use TenantCloud\BetterReflection\Relocated\React\Promise\Timer;
use TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream;
class UnwrapReadableTest extends \TenantCloud\BetterReflection\Relocated\React\Tests\Promise\Stream\TestCase
{
    private $loop;
    public function setUp()
    {
        $this->loop = \TenantCloud\BetterReflection\Relocated\React\EventLoop\Factory::create();
    }
    public function testReturnsReadableStreamForPromise()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
    }
    public function testClosingStreamMakesItNotReadable()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->assertFalse($stream->isReadable());
    }
    public function testClosingRejectingStreamMakesItNotReadable()
    {
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testClosingStreamWillCancelInputPromiseAndMakeStreamNotReadable()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        }, $this->expectCallableOnce());
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsErrorWhenPromiseRejects()
    {
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsErrorWhenPromiseResolvesWithWrongValue()
    {
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\resolve(0.001, $this->loop);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testReturnsClosedStreamIfInputStreamIsClosed()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $input->close();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $this->assertFalse($stream->isReadable());
    }
    public function testReturnsClosedStreamIfInputHasWrongValue()
    {
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve(42);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $this->assertFalse($stream->isReadable());
    }
    public function testReturnsStreamThatWillBeClosedWhenPromiseResolvesWithClosedInputStream()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $input->close();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsDataWhenInputEmitsData()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('data', $this->expectCallableOnceWith('hello world'));
        $input->emit('data', array('hello world'));
    }
    public function testEmitsErrorAndClosesWhenInputEmitsError()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('error', $this->expectCallableOnceWith(new \RuntimeException()));
        $stream->on('close', $this->expectCallableOnce());
        $input->emit('error', array(new \RuntimeException()));
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsEndAndClosesWhenInputEmitsEnd()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('end', $this->expectCallableOnce());
        $stream->on('close', $this->expectCallableOnce());
        $input->emit('end', array());
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsCloseOnlyOnceWhenClosingStreamMultipleTimes()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('end', $this->expectCallableNever());
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $stream->close();
    }
    public function testForwardsPauseToInputStream()
    {
        $input = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Stream\\ReadableStreamInterface')->getMock();
        $input->expects($this->once())->method('pause');
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->pause();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testPauseAfterCloseHasNoEffect()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $stream->pause();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testPauseAfterErrorDueToInvalidInputHasNoEffect()
    {
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\reject(new \RuntimeException());
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->pause();
    }
    public function testForwardsResumeToInputStream()
    {
        $input = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Stream\\ReadableStreamInterface')->getMock();
        $input->expects($this->once())->method('resume');
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->resume();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testResumeAfterCloseHasNoEffect()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $stream->resume();
    }
    public function testPipingStreamWillForwardDataEvents()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $output = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $outputPromise = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\buffer($output);
        $stream->pipe($output);
        $input->emit('data', array('hello'));
        $input->emit('data', array('world'));
        $input->end();
        $outputPromise->then($this->expectCallableOnceWith('helloworld'));
    }
    public function testClosingStreamWillCloseInputStream()
    {
        $input = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Stream\\ReadableStreamInterface')->getMock();
        $input->expects($this->once())->method('isReadable')->willReturn(\true);
        $input->expects($this->once())->method('close');
        $promise = \TenantCloud\BetterReflection\Relocated\React\Promise\resolve($input);
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
    }
    public function testClosingStreamWillCloseStreamIfItIgnoredCancellationAndResolvesLater()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $loop = $this->loop;
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function ($resolve) use($loop, $input) {
            $loop->addTimer(0.001, function () use($resolve, $input) {
                $resolve($input);
            });
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        \TenantCloud\BetterReflection\Relocated\Clue\React\Block\await($promise, $this->loop);
        $this->assertFalse($input->isReadable());
    }
    public function testClosingStreamWillCloseStreamFromCancellationHandler()
    {
        $input = new \TenantCloud\BetterReflection\Relocated\React\Stream\ThroughStream();
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        }, function ($resolve) use($input) {
            $resolve($input);
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $this->assertFalse($input->isReadable());
    }
    public function testCloseShouldRemoveAllListenersAfterCloseEvent()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $this->assertCount(1, $stream->listeners('close'));
        $stream->close();
        $this->assertCount(0, $stream->listeners('close'));
    }
    public function testCloseShouldRemoveReferenceToPromiseToAvoidGarbageReferences()
    {
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function () {
        });
        $stream = \TenantCloud\BetterReflection\Relocated\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $ref = new \ReflectionProperty($stream, 'promise');
        $ref->setAccessible(\true);
        $value = $ref->getValue($stream);
        $this->assertNull($value);
    }
}
