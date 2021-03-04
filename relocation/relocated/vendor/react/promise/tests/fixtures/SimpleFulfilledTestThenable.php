<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise;

class SimpleFulfilledTestThenable
{
    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        try {
            if ($onFulfilled) {
                $onFulfilled('foo');
            }
            return new self();
        } catch (\Throwable $exception) {
            return new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise($exception);
        } catch (\Exception $exception) {
            return new \TenantCloud\BetterReflection\Relocated\React\Promise\RejectedPromise($exception);
        }
    }
}
