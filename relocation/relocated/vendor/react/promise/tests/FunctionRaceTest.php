<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

class FunctionRaceTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    /** @test */
    public function shouldResolveEmptyInput()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(null));
        race([])->then($mock);
    }
    /** @test */
    public function shouldResolveValuesArray()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(1));
        race([1, 2, 3])->then($mock);
    }
    /** @test */
    public function shouldResolvePromisesArray()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(2));
        $d1 = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        $d2 = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        $d3 = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        race([$d1->promise(), $d2->promise(), $d3->promise()])->then($mock);
        $d2->resolve(2);
        $d1->resolve(1);
        $d3->resolve(3);
    }
    /** @test */
    public function shouldResolveSparseArrayInput()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(null));
        race([null, 1, null, 2, 3])->then($mock);
    }
    /** @test */
    public function shouldRejectIfFirstSettledPromiseRejects()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(2));
        $d1 = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        $d2 = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        $d3 = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        race([$d1->promise(), $d2->promise(), $d3->promise()])->then($this->expectCallableNever(), $mock);
        $d2->reject(2);
        $d1->resolve(1);
        $d3->resolve(3);
    }
    /** @test */
    public function shouldAcceptAPromiseForAnArray()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(1));
        race(resolve([1, 2, 3]))->then($mock);
    }
    /** @test */
    public function shouldResolveToNullWhenInputPromiseDoesNotResolveToArray()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(null));
        race(resolve(1))->then($mock);
    }
    /** @test */
    public function shouldRejectWhenInputPromiseRejects()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($this->identicalTo(null));
        race(reject())->then($this->expectCallableNever(), $mock);
    }
    /** @test */
    public function shouldCancelInputPromise()
    {
        $mock = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface')->getMock();
        $mock->expects($this->once())->method('cancel');
        race($mock)->cancel();
    }
    /** @test */
    public function shouldCancelInputArrayPromises()
    {
        $mock1 = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface')->getMock();
        $mock1->expects($this->once())->method('cancel');
        $mock2 = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface')->getMock();
        $mock2->expects($this->once())->method('cancel');
        race([$mock1, $mock2])->cancel();
    }
    /** @test */
    public function shouldNotCancelOtherPendingInputArrayPromisesIfOnePromiseFulfills()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->never())->method('__invoke');
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred($mock);
        $deferred->resolve();
        $mock2 = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface')->getMock();
        $mock2->expects($this->never())->method('cancel');
        race([$deferred->promise(), $mock2])->cancel();
    }
    /** @test */
    public function shouldNotCancelOtherPendingInputArrayPromisesIfOnePromiseRejects()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->never())->method('__invoke');
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred($mock);
        $deferred->reject();
        $mock2 = $this->getMockBuilder('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface')->getMock();
        $mock2->expects($this->never())->method('cancel');
        race([$deferred->promise(), $mock2])->cancel();
    }
}
