<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\ArrowFunctions;

class Foo
{
    public function doFoo()
    {
        $x = fn(string $str): int => 1;
        $y = fn(): array => ['a' => 1, 'b' => 2];
        die;
    }
}
