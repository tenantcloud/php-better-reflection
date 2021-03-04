<?php

namespace TenantCloud\BetterReflection\Relocated\React\Promise\PromiseAdapter;

use TenantCloud\BetterReflection\Relocated\React\Promise;
interface PromiseAdapterInterface
{
    public function promise();
    public function resolve();
    public function reject();
    public function notify();
    public function settle();
}
