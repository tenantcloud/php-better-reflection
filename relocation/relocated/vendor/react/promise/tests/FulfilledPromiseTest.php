<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

use TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter;
class FulfilledPromiseTest extends \TenantCloud\BetterReflection\Relocated\React\Promise\TestCase
{
    use PromiseTest\PromiseSettledTestTrait, PromiseTest\PromiseFulfilledTestTrait;
    public function getPromiseTestAdapter(callable $canceller = null)
    {
        $promise = null;
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter\CallbackPromiseAdapter(['promise' => function () use(&$promise) {
            if (!$promise) {
                throw new \LogicException('FulfilledPromise must be resolved before obtaining the promise');
            }
            return $promise;
        }, 'resolve' => function ($value = null) use(&$promise) {
            if (!$promise) {
                $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise($value);
            }
        }, 'reject' => function () {
            throw new \LogicException('TenantCloud\\BetterReflection\\Relocated\\You cannot call reject() for React\\Promise\\FulfilledPromise');
        }, 'notify' => function () {
            // no-op
        }, 'settle' => function ($value = null) use(&$promise) {
            if (!$promise) {
                $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise($value);
            }
        }]);
    }
    /** @test */
    public function shouldThrowExceptionIfConstructedWithAPromise()
    {
        $this->setExpectedException('\\InvalidArgumentException');
        return new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise(new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise());
    }
    /** @test */
    public function shouldNotLeaveGarbageCyclesWhenRemovingLastReferenceToFulfilledPromiseWithAlwaysFollowers()
    {
        \gc_collect_cycles();
        \gc_collect_cycles();
        // clear twice to avoid leftovers in PHP 7.4 with ext-xdebug and code coverage turned on
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise(1);
        $promise->always(function () {
            throw new \RuntimeException();
        });
        unset($promise);
        $this->assertSame(0, \gc_collect_cycles());
    }
    /** @test */
    public function shouldNotLeaveGarbageCyclesWhenRemovingLastReferenceToFulfilledPromiseWithThenFollowers()
    {
        \gc_collect_cycles();
        $promise = new \TenantCloud\BetterReflection\Relocated\React\Promise\FulfilledPromise(1);
        $promise = $promise->then(function () {
            throw new \RuntimeException();
        });
        unset($promise);
        $this->assertSame(0, \gc_collect_cycles());
    }
}
