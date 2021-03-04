<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4006;

interface Foo
{
    /**
     * @return never
     */
    public function bar();
}
class Bar implements \TenantCloud\BetterReflection\Relocated\Bug4006\Foo
{
    public function bar() : void
    {
        throw new \Exception();
    }
}
