<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

use TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter;
class LazyPromiseTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    use PromiseTest\FullTestTrait;
    public function getPromiseTestAdapter(callable $canceller = null)
    {
        $d = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred($canceller);
        $factory = function () use($d) {
            return $d->promise();
        };
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter(['promise' => function () use($factory) {
            return new \TenantCloud\BetterReflection\Relocated\React\Promise\LazyPromise($factory);
        }, 'resolve' => [$d, 'resolve'], 'reject' => [$d, 'reject'], 'notify' => [$d, 'progress'], 'settle' => [$d, 'resolve']]);
    }
    /** @test */
    public function shouldNotCallFactoryIfThenIsNotInvoked()
    {
        $factory = $this->createCallableMock();
        $factory->expects($this->never())->method('__invoke');
        new \TenantCloud\BetterReflection\Relocated\React\Promise\LazyPromise($factory);
    }
    /** @test */
    public function shouldCallFactoryIfThenIsInvoked()
    {
        $factory = $this->createCallableMock();
        $factory->expects($this->once())->method('__invoke');
        $p = new \TenantCloud\BetterReflection\Relocated\React\Promise\LazyPromise($factory);
        $p->then();
    }
    /** @test */
    public function shouldReturnPromiseFromFactory()
    {
        $factory = $this->createCallableMock();
        $factory->expects($this->once())->method('__invoke')->will($this->returnValue(new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise(1)));
        $onFulfilled = $this->createCallableMock();
        $onFulfilled->expects($this->once())->method('__invoke')->with($this->identicalTo(1));
        $p = new \TenantCloud\BetterReflection\Relocated\React\Promise\LazyPromise($factory);
        $p->then($onFulfilled);
    }
    /** @test */
    public function shouldReturnPromiseIfFactoryReturnsNull()
    {
        $factory = $this->createCallableMock();
        $factory->expects($this->once())->method('__invoke')->will($this->returnValue(null));
        $p = new \TenantCloud\BetterReflection\Relocated\React\Promise\LazyPromise($factory);
        $this->assertInstanceOf('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\PromiseInterface', $p->then());
    }
    /** @test */
    public function shouldReturnRejectedPromiseIfFactoryThrowsException()
    {
        $exception = new \Exception();
        $factory = $this->createCallableMock();
        $factory->expects($this->once())->method('__invoke')->will($this->throwException($exception));
        $onRejected = $this->createCallableMock();
        $onRejected->expects($this->once())->method('__invoke')->with($this->identicalTo($exception));
        $p = new \TenantCloud\BetterReflection\Relocated\React\Promise\LazyPromise($factory);
        $p->then($this->expectCallableNever(), $onRejected);
    }
}
