<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Process\Runnable;

use TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface;
interface Runnable
{
    public function getName() : string;
    public function run() : \TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface;
    public function cancel() : void;
}
