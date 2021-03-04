<?php

namespace TenantCloud\BetterReflection\Relocated\OverwritingVariable;

class Bar
{
    public function methodFoo() : \TenantCloud\BetterReflection\Relocated\OverwritingVariable\Foo
    {
    }
}
class Foo
{
}
