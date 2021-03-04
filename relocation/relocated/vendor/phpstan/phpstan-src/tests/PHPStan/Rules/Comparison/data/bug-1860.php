<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1860;

class Foo
{
    public function doFoo() : string
    {
    }
    public function doBar() : void
    {
        if ($this->doFoo() === null) {
            echo 'foo';
        }
        if ($this->doFoo() !== null) {
            echo 'bar';
        }
    }
}
