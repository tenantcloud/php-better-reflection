<?php

namespace TenantCloud\BetterReflection\Relocated\Bug1656;

class HelloWorld
{
    public function test() : void
    {
        return;
    }
    public function testVoidResult() : void
    {
        \true or $this->test();
    }
}
