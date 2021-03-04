<?php

namespace TenantCloud\BetterReflection\Relocated\ClassConstantNamespace;

class Foo
{
    const LOREM = 1;
    const IPSUM = 2;
    public function fooMethod()
    {
        self::class;
        self::LOREM;
        self::IPSUM;
    }
}
