<?php

// lint >= 8.0
namespace TenantCloud\BetterReflection\Relocated\MatchExprAnalysis;

class Foo
{
    public function doFoo()
    {
        match (lorem()) {
            ipsum() => dolor(),
            default => sit(),
        };
    }
}
