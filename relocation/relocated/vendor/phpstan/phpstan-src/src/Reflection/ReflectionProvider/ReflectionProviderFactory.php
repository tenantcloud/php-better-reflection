<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider;
class ReflectionProviderFactory
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider;
    private bool $disableRuntimeReflectionProvider;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $runtimeReflectionProvider, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider $staticReflectionProvider, bool $disableRuntimeReflectionProvider)
    {
        $this->runtimeReflectionProvider = $runtimeReflectionProvider;
        $this->staticReflectionProvider = $staticReflectionProvider;
        $this->disableRuntimeReflectionProvider = $disableRuntimeReflectionProvider;
    }
    public function create() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider
    {
        $providers = [];
        if (!$this->disableRuntimeReflectionProvider) {
            $providers[] = $this->runtimeReflectionProvider;
        }
        $providers[] = $this->staticReflectionProvider;
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\MemoizingReflectionProvider(\count($providers) === 1 ? $providers[0] : new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ReflectionProvider\ChainReflectionProvider($providers));
    }
}
