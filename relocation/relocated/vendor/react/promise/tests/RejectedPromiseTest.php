<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

use TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter;
class RejectedPromiseTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    use PromiseTest\PromiseSettledTestTrait, PromiseTest\PromiseRejectedTestTrait;
    public function getPromiseTestAdapter(callable $canceller = null)
    {
        $promise = null;
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter(['promise' => function () use(&$promise) {
            if (!$promise) {
                throw new \LogicException('RejectedPromise must be rejected before obtaining the promise');
            }
            return $promise;
        }, 'resolve' => function () {
            throw new \LogicException('TenantCloud\\BetterReflection\\Relocated\\You cannot call resolve() for React\\Promise\\RejectedPromise');
        }, 'reject' => function ($reason = null) use(&$promise) {
            if (!$promise) {
                $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise($reason);
            }
        }, 'notify' => function () {
            // no-op
        }, 'settle' => function ($reason = null) use(&$promise) {
            if (!$promise) {
                $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise($reason);
            }
        }]);
    }
    /** @test */
    public function shouldThrowExceptionIfConstructedWithAPromise()
    {
        $this->setExpectedException('\\InvalidArgumentException');
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise(new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise());
    }
    /** @test */
    public function shouldNotLeaveGarbageCyclesWhenRemovingLastReferenceToRejectedPromiseWithAlwaysFollowers()
    {
        \gc_collect_cycles();
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise(1);
        $promise->always(function () {
            throw new \RuntimeException();
        });
        unset($promise);
        $this->assertSame(0, \gc_collect_cycles());
    }
    /** @test */
    public function shouldNotLeaveGarbageCyclesWhenRemovingLastReferenceToRejectedPromiseWithThenFollowers()
    {
        \gc_collect_cycles();
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise(1);
        $promise = $promise->then(null, function () {
            throw new \RuntimeException();
        });
        unset($promise);
        $this->assertSame(0, \gc_collect_cycles());
    }
}
