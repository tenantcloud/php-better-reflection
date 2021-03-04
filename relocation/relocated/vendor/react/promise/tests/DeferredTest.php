<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

use TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter;
class DeferredTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    use PromiseTest\FullTestTrait;
    public function getPromiseTestAdapter(callable $canceller = null)
    {
        $d = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred($canceller);
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter(['promise' => [$d, 'promise'], 'resolve' => [$d, 'resolve'], 'reject' => [$d, 'reject'], 'notify' => [$d, 'progress'], 'settle' => [$d, 'resolve']]);
    }
    /** @test */
    public function progressIsAnAliasForNotify()
    {
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        $sentinel = new \stdClass();
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($sentinel);
        $deferred->promise()->then($this->expectCallableNever(), $this->expectCallableNever(), $mock);
        $deferred->progress($sentinel);
    }
    /** @test */
    public function shouldRejectWithoutCreatingGarbageCyclesIfCancellerRejectsWithException()
    {
        \gc_collect_cycles();
        \gc_collect_cycles();
        // clear twice to avoid leftovers in PHP 7.4 with ext-xdebug and code coverage turned on
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred(function ($resolve, $reject) {
            $reject(new \Exception('foo'));
        });
        $deferred->promise()->cancel();
        unset($deferred);
        $this->assertSame(0, \gc_collect_cycles());
    }
    /** @test */
    public function shouldRejectWithoutCreatingGarbageCyclesIfParentCancellerRejectsWithException()
    {
        \gc_collect_cycles();
        \gc_collect_cycles();
        // clear twice to avoid leftovers in PHP 7.4 with ext-xdebug and code coverage turned on
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred(function ($resolve, $reject) {
            $reject(new \Exception('foo'));
        });
        $deferred->promise()->then()->cancel();
        unset($deferred);
        $this->assertSame(0, \gc_collect_cycles());
    }
    /** @test */
    public function shouldRejectWithoutCreatingGarbageCyclesIfCancellerHoldsReferenceAndExplicitlyRejectWithException()
    {
        \gc_collect_cycles();
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred(function () use(&$deferred) {
        });
        $deferred->reject(new \Exception('foo'));
        unset($deferred);
        $this->assertSame(0, \gc_collect_cycles());
    }
    /** @test */
    public function shouldNotLeaveGarbageCyclesWhenRemovingLastReferenceToPendingDeferred()
    {
        \gc_collect_cycles();
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
        $deferred->promise();
        unset($deferred);
        $this->assertSame(0, \gc_collect_cycles());
    }
    /** @test */
    public function shouldNotLeaveGarbageCyclesWhenRemovingLastReferenceToPendingDeferredWithUnusedCanceller()
    {
        \gc_collect_cycles();
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred(function () {
        });
        $deferred->promise();
        unset($deferred);
        $this->assertSame(0, \gc_collect_cycles());
    }
    /** @test */
    public function shouldNotLeaveGarbageCyclesWhenRemovingLastReferenceToPendingDeferredWithNoopCanceller()
    {
        \gc_collect_cycles();
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred(function () {
        });
        $deferred->promise()->cancel();
        unset($deferred);
        $this->assertSame(0, \gc_collect_cycles());
    }
}
