<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3403;

interface Foo
{
    public function bar(...$baz) : void;
}
class AFoo implements \TenantCloud\BetterReflection\Relocated\Bug3403\Foo
{
    public function bar(...$baz) : void
    {
    }
}
