<?php

namespace TenantCloud\BetterReflection\Relocated\InstanceOfNamespace;

class Foo
{
    public function foobar()
    {
        if ($this instanceof self) {
        }
    }
}
