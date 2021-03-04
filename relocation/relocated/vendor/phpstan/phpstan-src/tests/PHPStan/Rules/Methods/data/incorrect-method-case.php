<?php

namespace TenantCloud\BetterReflection\Relocated\IncorrectMethodCase;

class Foo
{
    public function fooBar()
    {
        $this->foobar();
        $this->fooBar();
    }
}
