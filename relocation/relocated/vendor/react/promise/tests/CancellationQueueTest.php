<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

class CancellationQueueTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    /** @test */
    public function acceptsSimpleCancellableThenable()
    {
        $p = new \TenantCloud\BetterReflection\Relocated\React\Promise\SimpleTestCancellableThenable();
        $cancellationQueue = new \TenantCloud\BetterReflection\Relocated\React\Promise\CancellationQueue();
        $cancellationQueue->enqueue($p);
        $cancellationQueue();
        $this->assertTrue($p->cancelCalled);
    }
    /** @test */
    public function ignoresSimpleCancellable()
    {
        $p = new \TenantCloud\BetterReflection\Relocated\React\Promise\SimpleTestCancellable();
        $cancellationQueue = new \TenantCloud\BetterReflection\Relocated\React\Promise\CancellationQueue();
        $cancellationQueue->enqueue($p);
        $cancellationQueue();
        $this->assertFalse($p->cancelCalled);
    }
    /** @test */
    public function callsCancelOnPromisesEnqueuedBeforeStart()
    {
        $d1 = $this->getCancellableDeferred();
        $d2 = $this->getCancellableDeferred();
        $cancellationQueue = new \TenantCloud\BetterReflection\Relocated\React\Promise\CancellationQueue();
        $cancellationQueue->enqueue($d1->promise());
        $cancellationQueue->enqueue($d2->promise());
        $cancellationQueue();
    }
    /** @test */
    public function callsCancelOnPromisesEnqueuedAfterStart()
    {
        $d1 = $this->getCancellableDeferred();
        $d2 = $this->getCancellableDeferred();
        $cancellationQueue = new \TenantCloud\BetterReflection\Relocated\React\Promise\CancellationQueue();
        $cancellationQueue();
        $cancellationQueue->enqueue($d2->promise());
        $cancellationQueue->enqueue($d1->promise());
    }
    /** @test */
    public function doesNotCallCancelTwiceWhenStartedTwice()
    {
        $d = $this->getCancellableDeferred();
        $cancellationQueue = new \TenantCloud\BetterReflection\Relocated\React\Promise\CancellationQueue();
        $cancellationQueue->enqueue($d->promise());
        $cancellationQueue();
        $cancellationQueue();
    }
    /** @test */
    public function rethrowsExceptionsThrownFromCancel()
    {
        $this->setExpectedException('\\Exception', 'test');
        $mock = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface')->getMock();
        $mock->expects($this->once())->method('cancel')->will($this->throwException(new \Exception('test')));
        $cancellationQueue = new \TenantCloud\BetterReflection\Relocated\React\Promise\CancellationQueue();
        $cancellationQueue->enqueue($mock);
        $cancellationQueue();
    }
    private function getCancellableDeferred()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke');
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred($mock);
    }
}
