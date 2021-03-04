<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise\Timer;

use TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise\PromiseInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise\Promise;
function timeout(\TenantCloud\BetterReflection\Relocated\React\Promise\PromiseInterface $promise, $time, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
{
    // cancelling this promise will only try to cancel the input promise,
    // thus leaving responsibility to the input promise.
    $canceller = null;
    if ($promise instanceof \TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface || !\interface_exists('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface') && \method_exists($promise, 'cancel')) {
        // pass promise by reference to clean reference after cancellation handler
        // has been invoked once in order to avoid garbage references in call stack.
        $canceller = function () use(&$promise) {
            $promise->cancel();
            $promise = null;
        };
    }
    return new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function ($resolve, $reject) use($loop, $time, $promise) {
        $timer = null;
        $promise = $promise->then(function ($v) use(&$timer, $loop, $resolve) {
            if ($timer) {
                $loop->cancelTimer($timer);
            }
            $timer = \false;
            $resolve($v);
        }, function ($v) use(&$timer, $loop, $reject) {
            if ($timer) {
                $loop->cancelTimer($timer);
            }
            $timer = \false;
            $reject($v);
        });
        // promise already resolved => no need to start timer
        if ($timer === \false) {
            return;
        }
        // start timeout timer which will cancel the input promise
        $timer = $loop->addTimer($time, function () use($time, &$promise, $reject) {
            $reject(new \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\TimeoutException($time, 'Timed out after ' . $time . ' seconds'));
            // try to invoke cancellation handler of input promise and then clean
            // reference in order to avoid garbage references in call stack.
            if ($promise instanceof \TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface || !\interface_exists('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface') && \method_exists($promise, 'cancel')) {
                $promise->cancel();
            }
            $promise = null;
        });
    }, $canceller);
}
function resolve($time, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
{
    return new \TenantCloud\BetterReflection\Relocated\React\Promise\Promise(function ($resolve) use($loop, $time, &$timer) {
        // resolve the promise when the timer fires in $time seconds
        $timer = $loop->addTimer($time, function () use($time, $resolve) {
            $resolve($time);
        });
    }, function () use(&$timer, $loop) {
        // cancelling this promise will cancel the timer, clean the reference
        // in order to avoid garbage references in call stack and then reject.
        $loop->cancelTimer($timer);
        $timer = null;
        throw new \RuntimeException('Timer cancelled');
    });
}
function reject($time, \TenantCloud\BetterReflection\Relocated\React\EventLoop\LoopInterface $loop)
{
    return resolve($time, $loop)->then(function ($time) {
        throw new \TenantCloud\BetterReflection\Relocated\React\Promise\Timer\TimeoutException($time, 'Timer expired after ' . $time . ' seconds');
    });
}
