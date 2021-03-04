<?php

namespace TenantCloud\BetterReflection\Relocated\React\Dns\Query;

use TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise\Deferred;
use TenantCloud\BetterReflection\Relocated\React\Promise\PromiseInterface;
final class RetryExecutor implements \TenantCloud\BetterReflection\Relocated\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $retries;
    public function __construct(\TenantCloud\BetterReflection\Relocated\React\Dns\Query\ExecutorInterface $executor, $retries = 2)
    {
        $this->executor = $executor;
        $this->retries = $retries;
    }
    public function query(\TenantCloud\BetterReflection\Relocated\React\Dns\Query\Query $query)
    {
        return $this->tryQuery($query, $this->retries);
    }
    public function tryQuery(\TenantCloud\BetterReflection\Relocated\React\Dns\Query\Query $query, $retries)
    {
        $deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred(function () use(&$promise) {
            if ($promise instanceof \TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface || !\interface_exists('TenantCloud\\BetterReflection\\Relocated\\React\\Promise\\CancellablePromiseInterface') && \method_exists($promise, 'cancel')) {
                $promise->cancel();
            }
        });
        $success = function ($value) use($deferred, &$errorback) {
            $errorback = null;
            $deferred->resolve($value);
        };
        $executor = $this->executor;
        $errorback = function ($e) use($deferred, &$promise, $query, $success, &$errorback, &$retries, $executor) {
            if (!$e instanceof \TenantCloud\BetterReflection\Relocated\React\Dns\Query\TimeoutException) {
                $errorback = null;
                $deferred->reject($e);
            } elseif ($retries <= 0) {
                $errorback = null;
                $deferred->reject($e = new \RuntimeException('DNS query for ' . $query->name . ' failed: too many retries', 0, $e));
                // avoid garbage references by replacing all closures in call stack.
                // what a lovely piece of code!
                $r = new \ReflectionProperty('Exception', 'trace');
                $r->setAccessible(\true);
                $trace = $r->getValue($e);
                // Exception trace arguments are not available on some PHP 7.4 installs
                // @codeCoverageIgnoreStart
                foreach ($trace as &$one) {
                    if (isset($one['args'])) {
                        foreach ($one['args'] as &$arg) {
                            if ($arg instanceof \Closure) {
                                $arg = 'Object(' . \get_class($arg) . ')';
                            }
                        }
                    }
                }
                // @codeCoverageIgnoreEnd
                $r->setValue($e, $trace);
            } else {
                --$retries;
                $promise = $executor->query($query)->then($success, $errorback);
            }
        };
        $promise = $this->executor->query($query)->then($success, $errorback);
        return $deferred->promise();
    }
}
