<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Process\Runnable;

use TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface;
use TenantCloud\BetterReflection\Relocated\React\Promise\Deferred;
class RunnableStub implements \TenantCloud\BetterReflection\Relocated\PHPStan\Process\Runnable\Runnable
{
    /** @var string */
    private $name;
    /** @var Deferred */
    private $deferred;
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->deferred = new \TenantCloud\BetterReflection\Relocated\React\Promise\Deferred();
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function finish() : void
    {
        $this->deferred->resolve();
    }
    public function run() : \TenantCloud\BetterReflection\Relocated\React\Promise\CancellablePromiseInterface
    {
        /** @var CancellablePromiseInterface */
        return $this->deferred->promise();
    }
    public function cancel() : void
    {
        $this->deferred->reject(new \TenantCloud\BetterReflection\Relocated\PHPStan\Process\Runnable\RunnableCanceledException(\sprintf('Runnable %s canceled', $this->getName())));
    }
}
