<?php

// lint >= 7.4
namespace TenantCloud\BetterReflection\Relocated\DefinedVariablesCoalesceAssign;

class Foo
{
    public function doFoo()
    {
        $a ??= 'foo';
        $b['foo'] ??= 'bar';
    }
    public function doBar()
    {
        $a ??= $b;
    }
}
